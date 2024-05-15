<?php

namespace Tests\Feature\Api;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Swapi\ClientInterface as SwapiClient;
use App\Swapi\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class VehiclesTest extends TestCase
{
    use RefreshDatabase;

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_an_unsuccessful_response(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('request')->once()->andReturn(new Response(new GuzzleResponse()));
        });

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(422);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_a_successful_response_without_results_index(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('request')->once()->andReturn(new Response(new GuzzleResponse(body: '{}')));
        });

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(200);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_a_successful_response_with_results_index(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"results": [{"name": "CR90 Corvette", "model": "CR90 Corvette", "url": "http://swapi.test.swapi.orb.local/api/vehicles/2/","edited": "2014-12-20T21:23:49.867000Z"}]}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(200);
        $response->assertContent('{"results":[{"name":"CR90 Corvette","model":"CR90 Corvette","url":"http:\/\/swapi.test.swapi.orb.local\/api\/vehicles\/2\/","edited":"2014-12-20T21:23:49.867000Z","count":0}]}');
    }
}
