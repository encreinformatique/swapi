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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as Swg;

final class OtherController extends Controller
{
    /*
     * El parámetro $endpoint podría ser reemplazado por $request.getRequestUri(). (y sacaríamos getQueryString()))
     * Me parecería menos seguro, ya que $endpoint ha sido validado por regexp en api.php
     */
    #[Swg\Get('/films', responses: [new Swg\Response(response: 200, description: 'List of films')])]
    #[Swg\Get('/films/{id}', responses: [new Swg\Response(response: 200, description: 'Detail of a film')])]
    #[Swg\Get('/people', responses: [new Swg\Response(response: 200, description: 'List of people')])]
    #[Swg\Get('/people/{id}', responses: [new Swg\Response(response: 200, description: 'Detail of a person')])]
    #[Swg\Get('/planets', responses: [new Swg\Response(response: 200, description: 'List of planets')])]
    #[Swg\Get('/planets/{id}', responses: [new Swg\Response(response: 200, description: 'Detail of a planet')])]
    #[Swg\Get('/species', responses: [new Swg\Response(response: 200, description: 'List of species')])]
    #[Swg\Get('/species/{id}', responses: [new Swg\Response(response: 200, description: 'Detail of a specie')])]
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
