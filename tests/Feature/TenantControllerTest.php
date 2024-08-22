<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can display the tenant settings page', function () {
    $response = $this->withoutMiddleware()->get(route('dashboard.settings'));

    $response->assertStatus(200);

    $response->assertViewIs('pages.tenant.settings');
});
