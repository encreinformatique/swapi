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

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Illuminate\Support\Facades\Log;
use JsonException;
use Symfony\Component\HttpFoundation\Response as SfResponse;

/**
 * Sirve de Wrapper para la respuesta de Guzzle de Swapi.
 * Podríamos no usarla y procesar la respuesta de Guzzle, pero en tal caso, tendríamos que reemplazar las urls de la
 * API Swapi en cada Controller.
 */
final class Response implements ResponseInterface
{
    private int $statusCode;
    private array $content = [];

    public function __construct(private readonly GuzzleResponse $httpResponse)
    {
        $this->statusCode = $this->httpResponse->getStatusCode();
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): array
    {
        $content = $this->httpResponse->getBody();
        /*
         * Reemplazo en el string para evitar un bucle or array_walk_recursive.
         * Corregimos tambien un error en la API en formato Wookiee ya que reemplaza null por whhuanan. Eso genera
         * un error en el decoding del Json.
         */
        $content = str_replace('https://swapi.dev', getenv('APP_URL'), $content);
        $content = str_replace('whhuanan', 'null', $content);

        try {
            $this->content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            $this->content = ['message' => $exception->getMessage()];
            $this->statusCode = SfResponse::HTTP_UNPROCESSABLE_ENTITY;

            Log::critical($this->httpResponse->getBody());
        }

        return $this->content;
    }

    public function getHttpResponse(): GuzzleResponse
    {
        return $this->httpResponse;
    }
}
