<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::redirect('/', '/dashboard');

Route::get('/documentation/json', function () {
    $openapi = \OpenApi\Generator::scan(['../app']);
    return response()
        ->json($openapi)
        ->header('Content-Type', 'application/json');
})->name('documentation.json');

Route::view('documentation', 'documentation')
    ->name('documentation');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard.index');

Route::view('tenant/create', 'pages.tenant.create')
    ->middleware(['auth', 'verified'])
    ->name('tenant.create');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/dashboard/tenants', [App\Http\Controllers\dashbord\TenantController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('tenant.index');

Route::get('/dashboard/settings', [App\Http\Controllers\dashbord\TenantController::class, 'settings'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.settings');

require __DIR__ . '/dashboard/auth_web.php';
