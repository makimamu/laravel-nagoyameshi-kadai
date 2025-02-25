<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Admin;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Admin::class => AdminPolicy::class,
];
    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        if (App::environment('production')) {
            URL::forceScheme('https');

            $this->registerPolicies();

            // 管理者のみ許可
            Gate::define('admin', function (User $user) {
                return $user->role === 'admin'; // 'role' カラムが 'admin' のユーザーのみ許可
            });
        }
        Paginator::useBootstrap();
    }
}

