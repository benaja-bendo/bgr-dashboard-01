<?php

namespace App\Http\Controllers\TenantControllers;

use App\Models\Tenant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SchoolController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $tenants = Tenant::all();

        $response = [
            'success' => true,
            'message' => "Schools retrieved successfully.",
            'data' => $tenants->map(function ($tenant) {
                return [
                    'id' => $tenant->id,
                    'name' => $tenant->id,
                ];
            }),
        ];
        return response()->json($response, 200);
    }

}
