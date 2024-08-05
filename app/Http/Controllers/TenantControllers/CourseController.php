<?php

namespace App\Http\Controllers\TenantControllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Controllers\ApiController;

class CourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $courses = Course::with('stateCourse')->get();
        return $this->successResponse(CourseResource::collection($courses), 'Courses retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'states_course_id' => 'required|exists:states_courses,id',
        ]);

        $course = Course::create($validated);
        return $this->successResponse(new CourseResource($course), 'Course created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $course = Course::with('stateCourse')->find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }

        return $this->successResponse(new CourseResource($course), 'Course retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'states_course_id' => 'required|exists:states_courses,id',
        ]);

        $course->update($validated);
        return $this->successResponse(new CourseResource($course), 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }

        $course->delete();
        return $this->successResponse(null, 'Course deleted successfully.');
    }
}
