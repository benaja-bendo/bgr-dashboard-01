<?php

namespace App\Http\Controllers\CentralControllers\dashbord;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Foundation\Application;
use \App\Models\Tenant;

class TenantController extends Controller
{
    public function index(): View|Factory|Application
    {
        $tenants = Tenant::all();
        return view('pages.tenant.index',[
            'tenants' => $tenants
        ]);
    }

    public function settings(): View|Factory|Application
    {
        return view('pages.tenant.settings');
    }
}
