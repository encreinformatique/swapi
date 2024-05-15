<?php
/**
 * @package Tests\Swapi
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit\Swapi;

use App\Swapi\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Tests\TestCase;
use PHPUnit\Framework\Attributes as PHPUnit;

class ResponseTest extends TestCase
{
    private const CONTENT_EXAMPLE = '{"count": 1, "next": null, "previous": null, "results": [
    {
        "name": "Death Star",
        "model": "DS-1 Orbital Battle Station",
        "manufacturer": "Imperial Department of Military Research, Sienar Fleet Systems",
        "cost_in_credits": "1000000000000",
        "length": "120000",
        "max_atmosphering_speed": "n/a",
        "crew": "342,953",
        "passengers": "843,342",
        "cargo_capacity": "1000000000000",
        "consumables": "3 years",
        "hyperdrive_rating": "4.0",
        "MGLT": "10",
        "starship_class": "Deep Space Mobile Battlestation",
        "pilots": [],
        "films": [
            "https://swapi.dev/api/films/1/"
        ],
        "created": "2014-12-10T16:36:50.509000Z",
        "edited": "2014-12-20T21:26:24.783000Z",
        "url": "https://swapi.dev/api/starships/9/"
    }]}';

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function status_code_is_set_correctly(): void
    {
        $guzzleResponse = new GuzzleResponse(201);

        $response = new Response($guzzleResponse);

        self::assertEquals(201, $response->getStatusCode());
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function status_code_is_teapot(): void
    {
        $guzzleResponse = new GuzzleResponse(418);

        $response = new Response($guzzleResponse);

        self::assertEquals(418, $response->getStatusCode());
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function guzzle_response_is_kept(): void
    {
        $guzzleResponse = new GuzzleResponse();

        $response = new Response($guzzleResponse);

        self::assertSame($guzzleResponse, $response->getHttpResponse());
    }

    #[PHPUnit\Test]
    #[PHPUnit\Group('Swapi')]
    public function urls_are_replaced_correctly(): void
    {
        $guzzleResponse = new GuzzleResponse(body: self::CONTENT_EXAMPLE);

        $response = new Response($guzzleResponse);

        $content = $response->getContent();
        self::assertArrayHasKey('results', $content);
        self::assertCount(1, $content['results']);
        self::assertArrayHasKey('url', $content['results'][0]);
        self::assertEquals('http://swapi.test.swapi.orb.local/api/starships/9/', $content['results'][0]['url']);
    }
}
