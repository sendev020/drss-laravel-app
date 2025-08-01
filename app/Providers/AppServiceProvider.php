<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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
     // Active le HTTPS si l'app est derrière un proxy (Render le fait)
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }


    Route::model('role', Role::class);

    Schema::defaultStringLength(191);

    ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
        return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
    });
}
}
