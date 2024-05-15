<?php

namespace App\Http\Controllers\Api;

use App\Swapi\ClientInterface as SwapiClient;
use App\Swapi\NormalizerInterface as SwapiNormalizer;

abstract class Controller
{
    protected const RESULT_WOOKIE = 'rcwochuanaoc';

    public function __construct(
        protected SwapiClient $httpClient,
        protected SwapiNormalizer $normalizer
    ) {
    }
}
