<?php

namespace App\Http\Controllers\dashbord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = \App\Models\Tenant::all();
        return view('pages.tenant.index',[
            'tenants' => $tenants
        ]);
    }

    public function settings()
    {
        return view('pages.tenant.settings');
    }
}
