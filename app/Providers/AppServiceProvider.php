<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Force Root URL if deployed on Render
        if ($renderUrl = env('RENDER_EXTERNAL_URL')) {
            \Illuminate\Support\Facades\URL::forceRootUrl($renderUrl);
            config(['app.url' => $renderUrl]);
        }
    }
}
