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

final class EditController extends AbstractEditController
{
    protected const MODEL = Vehicle::class;

    protected function getEndpointSlug(): string
    {
        return Vehicle::ENDPOINT_SLUG;
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
