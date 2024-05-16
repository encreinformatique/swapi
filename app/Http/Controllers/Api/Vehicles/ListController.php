<?php
/**
 * @package App\Http\Controllers\Api
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   14/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\Vehicles;

use App\Http\Controllers\Api\AbstractListController;
use App\Models\Vehicle;
use OpenApi\Attributes as Swg;

#[Swg\Get('/vehicles', responses: [
    new Swg\Response(response: 200, description: 'List of Vehicles')
])]
final class ListController extends AbstractListController
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
}
