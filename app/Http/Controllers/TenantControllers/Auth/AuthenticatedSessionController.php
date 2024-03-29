<?php

namespace App\Http\Controllers\TenantControllers\Auth;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\ApiController;


class AuthenticatedSessionController extends ApiController
{
    /**
     * Handle an incoming authentication request.
     *
     * @return JsonResponse
     *
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'school_name' => 'required',
        ]);

        $tenant = Tenant::find($request->school_name);
        tenancy()->initialize($tenant);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return $this->successResponse(
                [
                    'token' => $token,
                    'user' => $user,
                    'tenant_id' => Crypt::encryptString($tenant->id),
                ], 'User logged in successfully.');
        }

        return $this->errorResponse('Invalid credentials', [], 401);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user(); // get the authenticated user
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete(); // delete the current token

        return $this->successResponse(null, 'User logged out successfully.');
    }
}
