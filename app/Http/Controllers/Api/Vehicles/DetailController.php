<?php
/**
 * @package App\Http\Controllers\Api\Starships
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api\Vehicles;

use App\Http\Controllers\Api\Controller;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;

final class DetailController extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $response = $this->httpClient->request('/vehicles/' . $id);

        $content = $this->normalizer
            ->setModel(Vehicle::class)
            ->normalizeRow($response->getContent());

        return response()->json($content, $response->getStatusCode());
    }
}
