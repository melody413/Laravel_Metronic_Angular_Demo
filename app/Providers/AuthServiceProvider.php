<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Dynamically register permissions with Laravel's Gate.
        Gate::define('admin.dataFrom.pharamcyInfo', function () { return true; });
        Gate::define('admin.dataFrom.labInfo', function () { return true; });
        Gate::define('admin.dataFrom.labInfo', function () { return true; });
        Gate::define('admin.dataFrom.labInfo', function () { return true; });
        Gate::define('admin.dataFrom.labInfo', function () { return true; });
        Gate::define('admin.dataFrom.labInfo', function () { return true; });
        Gate::define('admin.dataFrom.getInsuranceCompany', function () { return true; });
        Gate::define('admin.dataFrom.getSubs', function () { return true; });
        Gate::define('admin.dataFrom.uploadImages', function () { return true; });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {

                if($user->isSuperAdmin())
                    return true;

                $ex = explode('.', $permission->name);
                if($ex[2] == 'store')
                    return true;

                if($ex[2] == 'store' && ! $user->hasPermission($permission))
                {
                    $premCreate = $ex[0].'.'.$ex[1].'.create';
                    $premedit = $ex[0].'.'.$ex[1].'.create';

                    return $user->hasPermission($premCreate) || $premedit;
                }

                return $user->hasPermission($permission);
            });
        }

    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
