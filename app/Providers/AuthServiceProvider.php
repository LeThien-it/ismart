<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Attribute' => 'App\Policies\AttributePolicy',
        'App\Order' => 'App\Policies\OrderPolicy',
        'App\Page' => 'App\Policies\PagePolicy',
        'App\Post' => 'App\Policies\PostPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\Slider' => 'App\Policies\SliderPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $permissions = Permission::where('parent_id','!=',0)->get();
        foreach($permissions as $permission){
            Gate::define($permission->key_code, function ($user) use ($permission) {
                return $user->checkPermissionAccess($permission->key_code);
            });
        }
   
    }
}
