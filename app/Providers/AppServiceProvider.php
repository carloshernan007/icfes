<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use JeroenNoten\LaravelAdminLte\Http\ViewComposers\AdminLteComposer;

class AppServiceProvider extends ServiceProvider
{



    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Factory $view): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        $view->composer('vendor.adminlte.page', AdminLteComposer::class);
        require_once app_path('Helpers/LabelsHelper.php');
        require_once app_path('Helpers/AlertHelper.php');
    }
}
