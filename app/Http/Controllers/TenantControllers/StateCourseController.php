<?php

namespace App\Http\Controllers\TenantControllers;

use App\Models\StateCourse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class StateCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/state-courses',
        operationId: 'indexStateCourses',
        description: 'Get all state courses.',
        security: [['sanctum' => []]],
        tags: ['StateCourse'],
        responses: [
            new OA\Response(response: '200', description: 'State courses retrieved successfully.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
            new OA\Response(response: '404', description: 'Not found.'),
        ],
    )]
    public function index(): JsonResponse
    {
        $stateCourses = StateCourse::all();
        return $this->successResponse($stateCourses, 'State courses retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/api/v1/state-courses',
        operationId: 'storeStateCourse',
        description: 'Create a new state course.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true
        ),
        tags: ['StateCourse'],
        responses: [
            new OA\Response(response: '201', description: 'State course created successfully.'),
            new OA\Response(response: '400', description: 'Bad request.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
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
     * @param StateCourse $stateCourse
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/state-courses/{id}',
        operationId: 'showStateCourse',
        description: 'Get a specific state course by ID.',
        security: [['sanctum' => []]],
        tags: ['StateCourse'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the state course to retrieve.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'State course retrieved successfully.'),
            new OA\Response(response: '404', description: 'State course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
    public function show(StateCourse $stateCourse): JsonResponse
    {
        return $this->successResponse($stateCourse, 'State course retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param StateCourse $stateCourse
     * @return JsonResponse
     */
    #[OA\Put(
        path: '/api/v1/state-courses/{id}',
        operationId: 'updateStateCourse',
        description: 'Update an existing state course.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true
        ),
        tags: ['StateCourse'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the state course to update.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'State course updated successfully.'),
            new OA\Response(response: '404', description: 'State course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
            new OA\Response(response: '400', description: 'Bad request.'),
        ],
    )]
    public function update(Request $request, StateCourse $stateCourse): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
        ]);

        $stateCourse->update($validated);
        return $this->successResponse($stateCourse, 'State course updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     * @param StateCourse $stateCourse
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/api/v1/state-courses/{id}',
        operationId: 'destroyStateCourse',
        description: 'Delete a state course by ID.',
        security: [['sanctum' => []]],
        tags: ['StateCourse'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the state course to delete.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'State course deleted successfully.'),
            new OA\Response(response: '404', description: 'State course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
    public function destroy(StateCourse $stateCourse): JsonResponse
    {
        $stateCourse->delete();
        return $this->successResponse(null, 'State course deleted successfully.');
    }
}
