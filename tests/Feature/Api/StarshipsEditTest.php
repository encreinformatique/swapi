<?php

namespace Tests\Feature\Api;

use App\Swapi\ClientInterface as SwapiClient;
use App\Swapi\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes as PHPUnit;

class StarshipsEditTest extends TestCase
{
    use RefreshDatabase;

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_edit_the_inventory(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->patchJson('/api/starships/2', data: ['count' => 10]);

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":10}');
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_increments_the_inventory_by_one(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->patchJson('/api/starships/2/increment', data: ['count' => 2]);

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":2}');
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_increments_the_inventory(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->patchJson('/api/starships/2/increment');

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":1}');
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function the_api_decrements_the_inventory_by_one(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->patchJson('/api/starships/2/decrement');

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":0}');
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Controller')]
    public function subzero_not_possible(): void
    {
        $this->mock(SwapiClient::class, function (MockInterface $mock) {
            $guzzle = new GuzzleResponse(body: '{"name": "X-wing", "model": "T-65 X-wing", "url": "http://swapi.test.swapi.orb.local/api/starships/12/","edited": "2014-12-20T21:23:49.867000Z"}');

            $mock->shouldReceive('request')->once()->andReturn(new Response($guzzle));
        });

        $response = $this->patchJson('/api/starships/2/decrement', data: ['count' => 2]);

        $response->assertStatus(200);
        $response->assertContent('{"name":"X-wing","model":"T-65 X-wing","url":"http:\/\/swapi.test.swapi.orb.local\/api\/starships\/12\/","edited":"2014-12-20T21:23:49.867000Z","count":0}');
    }
}
