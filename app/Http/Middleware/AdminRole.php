<?php

namespace App\Http\Middleware;

use App\Admin;
use App\AdminRoleFeature;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $adminHasRole = checkRoleFeature($role);
        if(!$adminHasRole){
            return redirect(url('/')."/admin/unauthorize-access");
        }
        return $next($request);
    }
}
