<?php

namespace App\Providers;

use App\Models\Acara;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');

        View::composer('*', function ($view) {


            $acara = Acara::latest()->first();


            // Kirim ke semua blade
            $view->with([
                'acara' => $acara,
            ]);
        });
    }
}
