<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class TenancySetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $tenantCypher = $request->header('X-Tenant-Id');
            $tenant = Crypt::decrypt($tenantCypher, false);
            tenancy()->initialize($tenant);
        } catch (DecryptException $e) {
            return response()->json([
                'message' => 'Unauthorized - failed to decrypt tenant id',
                'error' => $e->getMessage()
            ], 401);
        } catch (TenantCouldNotBeIdentifiedById $e) {
            return response()->json([
                'message' => 'Unauthorized - Tenant not found',
                'error' => $e->getMessage()
            ], 401);
        }
        return $next($request);
    }
}
