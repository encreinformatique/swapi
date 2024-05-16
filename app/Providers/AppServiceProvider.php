<?php

namespace App\Providers;

use App\Swapi\Client as SwapiClient;
use App\Swapi\ClientInterface as SwapiClientInterface;
use App\Swapi\Dto as SwapiDto;
use App\Swapi\DtoInterface as SwapiDtoInterface;
use App\Swapi\Normalizer as SwapiNormalizer;
use App\Swapi\NormalizerInterface as SwapiNormalizerInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SwapiClientInterface::class, fn () => new SwapiClient());
        $this->app->bind(SwapiDtoInterface::class, fn () => new SwapiDto());
        $this->app->bind(SwapiNormalizerInterface::class, fn (Application $app) => new SwapiNormalizer($app[SwapiDtoInterface::class]));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
