<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
{
    $this->registerPolicies();

    // Define gates based on user_type
    Gate::define('manage-users', function ($user) {
        return $user->isAdmin();
    });

    Gate::define('view-own-profile', function ($user, $profileUser) {
        return $user->id === $profileUser->id && 
               ($user->isRegularUser() || $user->isAdmin());
    });

    Gate::define('update-own-profile', function ($user, $profileUser) {
        return $user->id === $profileUser->id && 
               ($user->isRegularUser() || $user->isAdmin());
    });

    Gate::define('view-categories', function ($user) {
        return $user->isAdmin() || $user->isRegularUser() || $user->isSubUser();
    });

    Gate::define('view-products', function ($user) {
        return $user->isAdmin() || $user->isRegularUser() || $user->isSubUser();
    });

    Gate::define('manage-categories', function ($user) {
        return $user->isAdmin();
    });

    Gate::define('manage-products', function ($user) {
        return $user->isAdmin();
    });

     Gate::define('update-profile', function ($user, $profileUser) {
        // Users can only update their own profile
        return $user->user_id === $profileUser->user_id;
    });

    Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
        return Hash::check($value, Auth::user()->password);
    });
}
}
