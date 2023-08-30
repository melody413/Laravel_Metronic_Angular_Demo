<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class AdminCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    use AuthorizesRequests;

    public function handle($request, Closure $next)
    {
        /*
                $permissions = $this->getPermissions();

                if(!in_array( \Request::route()->getName(),$permissions->pluck('name')->toArray()))
                    Gate::define(\Request::route()->getName() , function (){ return true;});

                Gate::define('admin.doctor_rate.delete' , function (){ return true;});

                if(Gate::allows('admin.doctor_rate.delete'))
                    dd('yes');*/

        Gate::define('admin.dashboard' , function (){ return true;});

        $this->authorize( \Request::route()->getName() );

        return $next($request);
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
