<?php

namespace App\Http\Controllers\TenantControllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;

class SchoolController extends Controller
{
    public function index(): JsonResponse
    {
        $tenants = Tenant::all();

        //TODO fix (le retour que les autres)
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
        return response()->json($response);
    }

}
