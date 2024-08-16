<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        Blade::component('login.components.application-logo', 'application-logo');
        Blade::component('login.components.auth-session-status', 'auth-session-status');
        Blade::component('login.components.danger-button', 'danger-button');
        Blade::component('login.components.dropdown-link', 'dropdown-link');
        Blade::component('login.components.dropdown', 'dropdown');
        Blade::component('login.components.input-error', 'input-error');
        Blade::component('login.components.input-label', 'input-label');
        Blade::component('login.components.modal', 'modal');
        Blade::component('login.components.nav-link', 'nav-link');
        Blade::component('login.components.primary-button', 'primary-button');
        Blade::component('login.components.responsive-nav-link', 'responsive-nav-link');
        Blade::component('login.components.secondary-button', 'secondary-button');
        Blade::component('login.components.text-input', 'text-input');

       
    }
}
