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
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    });

    Route::middleware(['tenancy.setup'])->group(function () {

        Route::get(
            '/test',
            function (Request $request) {
                $users = User::all();
                $response = [
                    'success' => true,
                    'message' => "Users retrieved successfully.",
                    'data' => new \App\Http\Resources\UserTenantCollection($users),
                ];

                return response()->json($response, 200);
            }
        );

        Route::post('/students/deletes', [StudentController::class, 'destroys']);
        Route::post('/students/import', [StudentController::class, 'import']);
        Route::get('/students/export-template', [StudentController::class, 'exportTemplate']);
        Route::get('/students/export', [StudentController::class, 'export']);

        Route::apiResource('/students', StudentController::class);

    });



    Route::get('/schools', [SchoolController::class,'index']);
});
