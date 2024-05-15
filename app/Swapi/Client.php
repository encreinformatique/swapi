<?php
/**
 * @package App\Swapi
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Swapi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

final class Client implements ClientInterface
{
    private const BASE_URL = 'https://swapi.dev/api/';

    /**
     * Swapi solo acepta GET.
     *
     * @param string $endpoint
     * @return Response
     */
    public function request(string $endpoint): Response
    {
        $url = sprintf('%s%s', self::BASE_URL, $endpoint);

        $client = new HttpClient();

        try {
            $response = $client->request('GET', $url);
        } catch (GuzzleException $exception) {
            return new Response(new GuzzleResponse($exception->getCode()));
        }

        return new Response($response);
    }
}
