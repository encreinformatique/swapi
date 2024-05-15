<?php

namespace Tests\Feature\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class IndexTest extends TestCase
{
    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_a_successful_response(): void
    {
        $response = $this->getJson('/api');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'films',
                'people',
                'planets',
                'species',
                'starships',
                'vehicles',
            ]);
    }
}
