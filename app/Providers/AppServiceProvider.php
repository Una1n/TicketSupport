<?php

namespace App\Providers;

use App;
use Illuminate\Database\Eloquent\Model;
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
        // Strict Mode when in development:
        // Guard against lazily loading (N+1) models when in development
        // Shows an exception if you're trying to fill an unfillable attribute in your model
        // Shows an exception if you're trying to access an attribute on the model that doesn't exist
        Model::shouldBeStrict(! App::isProduction());
    }
}
