<?php

namespace App\Providers;

use App\Http\ViewComposers\UserListComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $composers = [
            UserListComposer::class => ['home', 'auth.login'],
        ];

        foreach ($composers as $composer => $views) {
            View::composer($views, $composer);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
