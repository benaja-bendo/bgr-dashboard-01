<?php

use App\Models\StateCourse;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class)->beforeEach(function () {
    $this->tenant = Tenant::factory()->create([
        'id' => 'tenant-1',
        'domain' => 'tenant1.localhost',
    ]);
})->in('Feature');
