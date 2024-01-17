<?php

namespace App\Http\Controllers\TenantControllers;

use App\Http\Controllers\ApiController;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


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
        $students = Student::all();
        return $this->successResponse(data: $students, message: "Students retrieved successfully.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $student = User::create($validated);
        $student->assignRole('student');
        $student->student()->create();
        return $this->successResponse(data: $student, message: "Student created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $student = Student::find($id);
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

        $student = Student::find($id);
        $student->update($validated);
        return $this->successResponse(data: $student, message: "Student updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $student = Student::find($request->id);
        $student->delete();
        return $this->successResponse(data: null, message: "Student deleted successfully.");
    }

}
