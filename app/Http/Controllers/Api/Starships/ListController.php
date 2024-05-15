<?php
/**
 * @package App\Http\Controllers\Api
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   14/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\Starships;

use App\Http\Controllers\Api\AbstractListController;
use App\Models\Starship;

final class ListController extends AbstractListController
{
    protected const MODEL = Starship::class;

    protected function getEndpointSlug(): string
    {
        return Starship::ENDPOINT_SLUG;
    }

    protected function getModel(): string
    {
        return self::MODEL;
    }
}
