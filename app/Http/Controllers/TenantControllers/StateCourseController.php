<?php

namespace App\Http\Controllers\TenantControllers;

use App\Models\StateCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class StateCourseController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $stateCourses = StateCourse::all();
        return $this->successResponse($stateCourses, 'State courses retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $stateCourse = StateCourse::create($validated);
        return $this->successResponse($stateCourse, 'State course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StateCourse $stateCourse): JsonResponse
    {
        return $this->successResponse($stateCourse, 'State course retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StateCourse $stateCourse): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $stateCourse->update($validated);
        return $this->successResponse($stateCourse, 'State course updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StateCourse $stateCourse): JsonResponse
    {
        $stateCourse->delete();
        return $this->successResponse(null, 'State course deleted successfully.');
    }
}
