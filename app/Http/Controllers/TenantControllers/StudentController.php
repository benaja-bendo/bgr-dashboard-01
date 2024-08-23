<?php

namespace App\Http\Controllers\TenantControllers;

use App\Enums\RolesEnum;
use App\Exports\StudentsExport;
use App\Exports\StudentsTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentTenantCollection;
use App\Http\Resources\StudentTenantResource;
use App\Imports\StudentImport;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use OpenApi\Attributes as OA;

class StudentController extends Controller
{
    #[OA\Get(
        path: "/api/v1/students",
        operationId: "indexStudents",
        description: "Get all students",
        summary: "List all students",
        tags: ["Students"],
        parameters: [
            new OA\Parameter(
                name: "search",
                description: "Search students by first name, last name or email",
                in: "query",
                required: false,
                allowEmptyValue: false,
                schema: new OA\Schema(type: "string"),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'successful operation',
                content: [
                    new OA\JsonContent(ref: "#/components/schemas/User"),
                    new OA\XmlContent(ref: "#/components/schemas/User")
                ]
            ),
            new OA\Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $students = User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->when($request->search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })->orderBy('created_at', 'desc')->get();
        return $this->successResponse(
            data: new StudentTenantCollection($students),
            message: "Students retrieved successfully.");
    }

    #[OA\Post(
        path: "/api/v1/students",
        operationId: "storeStudent",
        description: "Create a new student",
        summary: "Create student",
        requestBody: new OA\RequestBody(
            description: "Student data",
            required: true,
            content: [
                new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        title: "User",
                        description: "User model",
                        required: ["last_name", "first_name", "email", "password"],
                        properties: [
                            new OA\Property(property: "last_name", description: "Last name of the user", type: "string"),
                            new OA\Property(property: "first_name", description: "First name of the user", type: "string"),
                            new OA\Property(property:"email", description: "Email of the user", type: "string"),
                            new OA\Property(property:"password", description: "Password of the user", type: "string"),
                        ]
                    )),
            ]
        ),
        tags: ["Students"],
        responses: [
            new OA\Response(
                response: 201,
                description: 'successful operation',
                content: [
                    new OA\JsonContent(ref: "#/components/schemas/User"),
                    new OA\XmlContent(ref: "#/components/schemas/User")
                ]
            ),
            new OA\Response(response: 422, description: 'Invalid input'),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'nullable',
            'email' => 'required|email|unique:users',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'nullable|numeric',
        ]);

        $password = Hash::make($this->generateSecurePassword());
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = tenantSaveFileToStorageDirectory($request, 'avatar', 'avatars_student');
        } else {
            $fullName = $validated['first_name'] . ' ' . $validated['last_name'];
            $validated['avatar'] = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . $fullName;
        }
        $userStudent = User::create([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'] ?? null,
            'email' => $validated['email'],
            'password' => $password,
            'avatar' => $validated['avatar'],
        ]);
        $userStudent->assignRole(RolesEnum::student->value);
        $userStudent->numberPhone()->create([
            'phone_number' => $validated['phone_number'] ?? null,
        ]);
        return $this->successResponse(
            data: null,
            message: "Student created successfully.",
            code: 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $student = User::find($id);
        if (!$student) {
            return $this->errorResponse(error: "Student not found", code: 404);
        }
        return $this->successResponse(
            data: new StudentTenantResource($student),
            message: "Student retrieved successfully.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {

        $validated = $request->validate([
            'last_name' => 'nullable',
            'first_name' => 'nullable',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|numeric',
        ]);
        // check if email is unique and not the same as the current email
        if (isset($validated['email'])) {
            $email = User::where('email', $validated['email'])->where('id', '!=', $id)->first();
            if ($email) {
                return $this->errorResponse(error: "Email already exists", code: 422);
            }
        }

        $student = User::find($id);
        $student->update($validated);
        $student->numberPhone()->create([
            'phone_number' => $validated['phone_number'] ?? null,
        ]);
        return $this->successResponse(
            data: new StudentTenantResource($student),
            message: "Student updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        User::findOrFail($id)->forceDelete();
        return $this->successResponse(data: null, message: "Student deleted successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroys(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array|min:1',
        ]);
        $ids_students = $request->ids;
        if (!empty($ids_students)) {
            User::whereIn('id', $ids_students)->forceDelete();
            return $this->successResponse(data: null, message: "Students deleted successfully.");
        }
        return $this->errorResponse(error: "No students selected", code: 404);
    }

    /**
     * @param int $length Length of the password to generate
     * @return string
     * @throws \Exception
     */
    private function generateSecurePassword(int $length = 16): string
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }

    /**
     * Import students from excel by using Maatwebsite\Excel\Excel
     * @param Request $request
     * @return JsonResponse
     */
    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            $studentsImport = (new StudentImport())->toCollection($request->file('file'));
            return $this->successResponse(
                data: ['students' => $studentsImport],
                message: "Students imported successfully.");
        } catch (ValidationException $e) {
            return $this->errorResponse(error: $e->getMessage(), errorMessages: $e->errors(), code: 422);
        }
    }

    /**
     * Export students to excel by using Maatwebsite\Excel\Excel
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    /**
     * Export students template to excel by using Maatwebsite\Excel\Excel
     * @return BinaryFileResponse
     */
    public function exportTemplate(): BinaryFileResponse
    {
        return Excel::download(new StudentsTemplateExport, 'students_template.xlsx');
    }

    /**
     * Upload image for student
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function uploadImage(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $student = User::find($id);
        if (!$student) {
            return $this->errorResponse(error: "Student not found", code: 404);
        }
        $student->avatar = tenantSaveFileToStorageDirectory($request, 'avatar', 'avatars_student');
        $student->save();

        return $this->successResponse(
            data: new StudentTenantResource($student),
            message: "Image uploaded successfully.");
    }

    /**
     * Search students
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'required',
        ]);
        $search = $request->search;
        $students = User::role(RolesEnum::student->value)
            ->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->get();
        return $this->successResponse(
            data: new StudentTenantCollection($students),
            message: "Students retrieved successfully.");
    }
}
