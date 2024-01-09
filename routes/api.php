<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
Route::get('tenant/create/user', function (Request $request) {
    $tenant = \App\Models\Tenant::find('foo');
    tenancy()->initialize($tenant);
//    create user
    $user = \App\Models\User::factory()->create();
// Créer un token avec l'ID du locataire actuel comme revendication personnalisée
    $token = $user->createToken(name: 'token-name', abilities: [$tenant->id])->plainTextToken;
    return response()->json([
        'user' => $user,
        'token' => $token
    ], 200);
})->middleware(\App\Http\Middleware\TenancySetup::class);

// detect tenant with middleware
Route::get('current-tenant', function (Request $request) {
    $tenant = \App\Models\Tenant::find('foo');
    tenancy()->initialize($tenant);

    $tenants = \App\Models\Tenant::all();
    return response()->json([
        'tenants' => $tenants
    ], 200);
})->middleware(\App\Http\Middleware\TenancySetup::class);


/*
 * ---------------------
 * API
 * ---------------------
 */
Route::get(
    '/item',
    function (Request $request) {
        $users = \App\Models\User::all();
        return response()->json([
            'users' => $users,
        ], 200);
    })->middleware(\App\Http\Middleware\TenancySetup::class);

Route::post('/login', function (Request $request) {
    $user = \App\Models\User::where('email', $request->username)->first();
    $token = $user->createToken('token-name')->plainTextToken;
    $tenant = \App\Models\Tenant::find($request->school_name);
    $response = [
        'success' => true,
        'message' => "Schools retrieved successfully.",
        'data' => [
            'token' => $token,
            'user' => new \App\Http\Resources\UserResource($user),
            'tenant_id' => Crypt::encryptString($tenant->id),
        ],
    ];
    return response()->json($response, 200);
});
Route::post('/logout', function () {
    $response = [
        'success' => true,
        'message' => "Logged out",
        'data' =>null,
    ];
    return response()->json($response, 200);
});

Route::get('/schools', function () {
    $tenants = \App\Models\Tenant::all();

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
});
