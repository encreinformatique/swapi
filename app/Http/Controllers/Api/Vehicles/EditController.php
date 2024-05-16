<?php
/**
 * @package App\Http\Controllers\Api\Vehicles
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\Vehicles;

use App\Http\Controllers\Api\AbstractEditController;
use App\Models\Vehicle;
use App\Swapi\Response as SwapiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as Swg;

final class EditController extends AbstractEditController
{
    protected const MODEL = Vehicle::class;

    #[Swg\Patch('/vehicles/{id}', requestBody: new Swg\RequestBody(description: 'Json with the count of Vehicles', required: true, content: new Swg\JsonContent([
        new Swg\Examples('{"count": 15}', '15 Vehicles in the inventory.', value: '{"count": 15}')
    ])), responses: [
        new Swg\Response(response: 200, description: 'Inventory modified'),
        new Swg\Response(response: 304, description: 'Inventory has not changed'),
        new Swg\Response(response: 400, description: 'Missing count field in request'),
        new Swg\Response(response: 404, description: 'Object could not be found'),
    ])]
    public function __invoke(int $id, Request $request): JsonResponse
    {
        return parent::__invoke($id, $request);
    }

    #[Swg\Patch('/vehicles/{id}/increment',
        description: 'Increase with the number received in the request. In case of no payload, default number is 1.',
        requestBody: new Swg\RequestBody(description: 'Json with the number of Vehicles to increase', required: false, content: new Swg\JsonContent([
            new Swg\Examples('{"count": 15}', '15 Vehicles in the inventory.', value: '{"count": 15}')
        ])),
        responses: [
        new Swg\Response(response: 200, description: 'Inventory modified'),
        new Swg\Response(response: 404, description: 'Object could not be found'),
    ])]
    public function increment(int $id, Request $request): JsonResponse
    {
        $number = $this->computeNumberFromRequest($request);

        return $this->changeCountOn(self::ACTION_INCREMENT, $id, $number ?? 1);
    }

    #[Swg\Patch('/vehicles/{id}/decrement',
        description: 'Decrease with the number received in the request. In case of no payload, default number is 1.',
        requestBody: new Swg\RequestBody(description: 'Json with the number of Vehicles to decrease', required: false, content: new Swg\JsonContent([
            new Swg\Examples('{"count": 15}', '15 Vehicles in the inventory.', value: '{"count": 15}')
        ])),
        responses: [
        new Swg\Response(response: 200, description: 'Inventory modified'),
        new Swg\Response(response: 404, description: 'Object could not be found'),
    ])]
    public function decrement(int $id, Request $request): JsonResponse
    {
        $number = $this->computeNumberFromRequest($request);

        return $this->changeCountOn(self::ACTION_DECREMENT, $id, $number ?? 1);
    }

    protected function getModel(): string
    {
        return self::MODEL;
    }

    protected function requestSwapi(int $id): SwapiResponse
    {
        $swapiUrl = sprintf('/%s/%d', Vehicle::ENDPOINT_SLUG, $id);

        return $this->httpClient->request($swapiUrl);
    }
}
