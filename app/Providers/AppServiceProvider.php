<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Pagination\Paginator;

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
        // Passport Settings
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // Paginator Links CSS
        Paginator::useBootstrapFive();

        //Password Reset Settings
        ResetPassword::createUrlUsing(function (User $user, string $token) {

            // Init Url Value
            $url = '';

            // Get Garlito Forget Password Type [ It can be either 'internal_url' either 'external_url'
            $garlito_forget_password_type = env('GARLITO_FORGET_PASSWORD_TYPE', 'internal_url');

            // In case it's 'external_url' developer has also to add the external url
            if($garlito_forget_password_type == 'external_url'){
                $url = env('GARLITO_FORGET_PASSWORD_EXTERNAL_URL', url());
            }

            // In case it's 'internal_url' the url is fixed.
            if($garlito_forget_password_type == 'external_url'){
                $url =  url('/');
            }

            return $url . '/reset-password?token='.$token;
        });
    }
}
