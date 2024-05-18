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
//        ->header('Content-Type', 'application/yaml');
})->name('documentation.json');

Route::view('documentation', 'documentation')
    ->name('documentation');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('tenant', 'pages.tenant.create')
    ->middleware(['auth', 'verified'])
    ->name('tenant.create');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
