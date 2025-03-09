<?php

namespace App\Providers;

use App\Models\BanksEmployees;
use App\Models\FixedEntries;
use App\Models\ReceivablesLoans;
use App\Models\User;
use App\Policies\BankEmployeePolicy;
use App\Policies\FixedEntriesPolicy;
use App\Policies\ReceivablesLoansPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('abilities', function() {
            return include base_path('data/abilities.php');
        });
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        //Authouration

        Gate::before(function ($user, $ability) {
            if($user instanceof User) {
                if($user->super_admin) {
                    return true;
                }
            }
        });
        // the Authorization for Report Page
        Gate::define('report.view', function ($user) {
            if($user instanceof User) {
                if($user->roles->contains('role_name', 'report.view')) {
                    return true;
                }
                return false;
            }
        });
        Gate::define('admins.backup', function ($user) {
            if($user instanceof User) {
                if($user->roles->contains('role_name', 'admins.backup')) {
                    return true;
                }
                return false;
            }
        });
        Gate::policy(FixedEntries::class, FixedEntriesPolicy::class);
        Gate::policy(BanksEmployees::class, BankEmployeePolicy::class);
        Gate::policy(ReceivablesLoans::class, ReceivablesLoansPolicy::class);


    }
}
