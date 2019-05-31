<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-research', static::checkExtraClass("c_research"));
    }

    protected static function checkExtraClass(string $class)
    {
        return function ($user) use ($class) {
            if ($user->role !== 'admin') {
                return false;
            }

            if (strpos($user->extra_class, $class) === false) {
                return false;
            }

            return true;
        };
    }
}
