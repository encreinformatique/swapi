<?php
/**
 * @package App\Http\Controllers\Api
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class OtherController extends Controller
{
    /**
     * El parámetro $endpoint podría ser reemplazado por $request.getRequestUri(). (y sacaríamos getQueryString()))
     * Me parecería menos seguro, ya que $endpoint ha sido validado por regexp en api.php
     *
     * @param string $endpoint
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function __invoke(string $endpoint, Request $request): JsonResponse
    {
        $endpoint.= $request->getQueryString() ? '?'.$request->getQueryString() : '';

        $response = $this->httpClient->request($endpoint);

        /*
         * Devolvemos código y contenido que Swapi nos devuelve.
         * La respuesta ya está procesada para reemplazar la URL de Api.
         */
        return response()->json($response->getContent(), $response->getStatusCode());
    }
}
