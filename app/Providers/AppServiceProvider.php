<?php

namespace App\Providers;

use App\Swapi\Client as SwapiClient;
use App\Swapi\ClientInterface as SwapiClientInterface;
use App\Swapi\Normalizer as SwapiNormalizer;
use App\Swapi\NormalizerInterface as SwapiNormalizerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SwapiClientInterface::class, fn () => new SwapiClient());
        $this->app->bind(SwapiNormalizerInterface::class, fn () => new SwapiNormalizer());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
