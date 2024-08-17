<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "0.1",
    description: "Base app API",
    title: "Bgrfacile API",
    termsOfService: "https://bgrfacile.com/tos",
    contact: new OA\Contact(email: "contact@bgrfacile.com"),
    license: new OA\License(name: "MIT", url: "https://bgrfacile.com"),
)]
#[OA\OpenApi(
    security: [
        new OA\SecurityScheme(
            securityScheme: "bearerAuth",
            type: "http",
            bearerFormat: "JWT",
            scheme: "bearer",
        )
    ],
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    description: "Authentification par jeton porteur JWT",
    bearerFormat: "JWT",
    scheme: "bearer",

)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send a success response.
     *
     * @param array|object|null $data
     * @param null $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public function successResponse(array|object|null $data, $message = null, int $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * Send an error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     *
     * @return JsonResponse
     */
    public function errorResponse(string $error, array $errorMessages = [], int $code = ResponseAlias::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Send an error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param int $code
     *
     * @return JsonResponse
     */
    public function sendErrorWithCode(string $error, array $errorMessages = [], int $code = ResponseAlias::HTTP_NOT_FOUND): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Send response with pagination.
     *
     * @param $items
     * @param $data
     *
     * @return JsonResponse
     */
    public function respondWithPagination($items, $data): JsonResponse
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $items->total(),
                'total_pages' => ceil($items->total() / $items->perPage()),
                'current_page' => $items->currentPage(),
                'limit' => $items->perPage()
            ]
        ]);

        return $this->successResponse($data, 'Data retrieved successfully.');
    }
}
