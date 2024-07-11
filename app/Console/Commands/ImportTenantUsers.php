<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
//use Stancl\Tenancy\Tenant;
use Illuminate\Support\Facades\Artisan;

class ImportTenantUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:import-users';
//    protected $signature = 'tenants:import-users {tenant} {--force} {--no-interaction} {--no-progress} {--no-ansi} {--env=} {--quiet} {--verbose} {--version} {--ansi} {--no-interaction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import UserTenant models for all tenants';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Tenant::all()->each(function ($tenant) {
            tenancy()->initialize($tenant);

            $this->info("Importing users for tenant {$tenant->id}");

            Artisan::call('scout:import', [
                'model' => 'App\Models\UserTenant'
            ]);

            $this->info("Finished importing users for tenant {$tenant->id}");

            tenancy()->end();
        });

        return 0;
    }
}
