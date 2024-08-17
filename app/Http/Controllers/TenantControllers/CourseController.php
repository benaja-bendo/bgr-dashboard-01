<?php

namespace App\Http\Controllers\TenantControllers;

use App\Http\Filters\NameFilter;
use App\Http\Resources\CourseCollection;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use OpenApi\Attributes as OA;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/courses',
        operationId: 'index',
        description: 'Get all courses with filter.',
        security: [['sanctum' => []]],
        tags: ['Course'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                description: 'Page number.',
                in: "query",
                required: false,
                schema: new OA\Schema(type: 'integer'),
            ),
            new OA\Parameter(
                name: 'limit',
                description: 'Items per page.',
                in: "query",
                required: false,
                schema: new OA\Schema(type: 'integer'),
            ),
            new OA\Parameter(
                name: 'name',
                description: 'Name of the user.',
                in: "query",
                required: false,
                schema: new OA\Schema(type: 'string'),
            )
        ],
        responses: [
            new OA\Response(response: '200', description: 'Courses retrieved successfully.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
            new OA\Response(response: '404', description: 'Not found.'),
        ],
    )]
    public function index(): JsonResponse
    {
        $pipelines = [
            NameFilter::class,
        ];

        $courses = Pipeline::send(Course::query()->with('stateCourse'))
            ->through($pipelines)
            ->thenReturn()
            ->paginate($request->limit ?? 10);

        return $this->successResponse(
            data: new CourseCollection($courses),
            message: 'Courses retrieved successfully.'
        );
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    #[OA\Post(
        path: '/api/v1/courses',
        operationId: 'store',
        description: 'Create a new course.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
        ),
        tags: ['Course'],
        responses: [
            new OA\Response(response: '201', description: 'Course created successfully.'),
            new OA\Response(response: '400', description: 'Bad request.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'states_course_id' => 'required|exists:states_courses,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $course = Course::create($validated);
        return $this->successResponse(
            data: new CourseResource($course),
            message: 'Course created successfully.'
        );
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/api/v1/courses/{id}',
        operationId: 'show',
        description: 'Get a specific course by ID.',
        security: [['sanctum' => []]],
        tags: ['Course'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the course to retrieve.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'Course retrieved successfully.'),
            new OA\Response(response: '404', description: 'Course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
    public function show(int $id): JsonResponse
    {
        $course = Course::with('stateCourse')->find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }

        return $this->successResponse(
            data: new CourseResource($course),
            message: 'Course retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    #[OA\Put(
        path: '/api/v1/courses/{id}',
        operationId: 'update',
        description: 'Update an existing course.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true
        ),
        tags: ['Course'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the course to update.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'Course updated successfully.'),
            new OA\Response(response: '404', description: 'Course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
            new OA\Response(response: '400', description: 'Bad request.'),
        ],
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'states_course_id' => 'required|exists:states_courses,id',
        ]);

        $course->update($validated);

        return $this->successResponse(
            data: new CourseResource($course),
            message: 'Course updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/api/v1/courses/{id}',
        operationId: 'destroy',
        description: 'Delete a course by ID.',
        security: [['sanctum' => []]],
        tags: ['Course'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID of the course to delete.',
                in: "path",
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
        responses: [
            new OA\Response(response: '200', description: 'Course deleted successfully.'),
            new OA\Response(response: '404', description: 'Course not found.'),
            new OA\Response(response: '401', description: 'Unauthorized.'),
        ],
    )]
    public function destroy(int $id): JsonResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->errorResponse('Course not found', [], 404);
        }


        $course->delete();
        return $this->successResponse(
            data: null,
            message: 'Course deleted successfully.'
        );
    }
}
