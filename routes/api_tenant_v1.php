<?php

use App\Http\Controllers\TenantControllers\SchoolController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantControllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TenantControllers\StudentController;



Route::prefix('v1')->group(function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::post('logout', [AuthenticatedSessionController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::middleware(['tenancy.setup'])->group(function () {

        Route::get(
            '/test',
            function (Request $request) {
                $users = User::all();
                return response()->json([
                    'users' => $users,
                ], 200);
            }
        );

        Route::apiResource('/students', StudentController::class)->middleware('auth:sanctum');

    });



    Route::get('/schools', [SchoolController::class,'index']);
});
