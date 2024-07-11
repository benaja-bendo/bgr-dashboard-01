<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\TenantControllers\CalendarEventController;
use App\Http\Controllers\TenantControllers\SchoolController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantControllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TenantControllers\StudentController;


Route::prefix('v1')->group(function () {
    Route::middleware(['tenancy.setup'])->group(function () {
        Route::post('/students/deletes', [StudentController::class, 'destroys']);
        Route::post('/students/import', [StudentController::class, 'import']);
        Route::get('/students/export-template', [StudentController::class, 'exportTemplate']);
        Route::get('/students/export', [StudentController::class, 'export']);
        Route::post('/students/{id}/upload-image', [StudentController::class, 'uploadImage']);

        Route::apiResource('/students', StudentController::class);

        // Calendar Events
        Route::apiResource('/calendar-events', CalendarEventController::class);

        Route::get('/search', [SearchController::class, 'search']);

    });

    Route::get('/schools', [SchoolController::class, 'index']);
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    });
});
