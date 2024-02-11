<?php

namespace App\Http\Controllers\TenantControllers;

use App\Enums\RolesEnum;
use App\Http\Controllers\ApiController;
use App\Http\Resources\StudentTenantResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
//        $students = User::all();
//        $students = User::role(RolesEnum::student->value)->get();
        $students = User::role(RolesEnum::student->value)->get();
        return $this->successResponse(
            data: StudentTenantResource::collection($students),
//            data: new StudentTenantCollection($students),
            message: "Students retrieved successfully.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'nullable',
            'email' => 'required',
        ]);

        $password = Hash::make($this->generateSecurePassword());
        $userStudent = User::create([
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
            'password' => $password,
        ]);
        $userStudent->assignRole(RolesEnum::student->value);
        $userStudent->student()->create();
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
        return $this->successResponse(data: $student, message: "Student retrieved successfully.");
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
            'name' => 'required',
            'email' => 'required',
        ]);

        $student = User::find($id);
        $student->update($validated);
        return $this->successResponse(data: $student, message: "Student updated successfully.");
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
        User::findOrFail($id)->delete();
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
            User::whereIn('id', $ids_students)->delete();
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
}
