<?php

namespace App\Http\Controllers;

use App\Models\UserTenant;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->input('query');

        $results = UserTenant::search($query)->get();

        return $this->successResponse(
            data: $results,
            message: 'Search results for ' . $query
        );
    }
}
