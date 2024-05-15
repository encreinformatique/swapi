<?php

namespace Tests\Feature\Api;

use App\Swapi\ClientInterface as SwapiClient;
use App\Swapi\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes as PHPUnit;

class StarshipsDetailTest extends TestCase
{
    use RefreshDatabase;

//    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_an_unsuccessful_response(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('request')->once()->andReturn(new Response(new GuzzleResponse()));
        });

        $response = $this->getJson('/api/starships/2');

        $response->assertStatus(422);
    }

//    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_a_successful_response_without_results_index(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $mock->shouldReceive('request')->once()->andReturn(new Response(new GuzzleResponse(body: '{}')));
        });

        $response = $this->getJson('/api/starships/2');

        $response->assertStatus(200);
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_returns_a_successful_response_with_results_index(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->getJson('/api/starships/12');

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":0}');
    }
}
