<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantControllers\CourseController;
use App\Http\Controllers\TenantControllers\SchoolController;
use App\Http\Controllers\TenantControllers\StudentController;
use App\Http\Controllers\TenantControllers\StateCourseController;
use App\Http\Controllers\TenantControllers\CalendarEventController;
use App\Http\Controllers\TenantControllers\Auth\AuthenticatedSessionController;


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

        //courses
        Route::apiResource('state-courses', StateCourseController::class);
        Route::apiResource('courses', CourseController::class);
    });

    Route::get('/schools', [SchoolController::class, 'index']);
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    });
});
