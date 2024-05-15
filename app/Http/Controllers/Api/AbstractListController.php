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

abstract class AbstractListController extends Controller
{
    abstract protected function getEndpointSlug(): string;
    abstract protected function getModel(): string;

    public function __invoke(Request $request): JsonResponse
    {
        $endpoint = $this->getEndpointSlug();
        $endpoint.= $request->getQueryString() ? '?'.$request->getQueryString() : '';

        $response = $this->httpClient->request($endpoint);

        $content = $response->getContent();
        if ($response->getStatusCode() === 200) {
            $content = $this->normalizer
                ->setModel($this->getModel())
                ->normalize($response->getContent(), $request->query->get('format', ''));
        }

        return response()->json($content, $response->getStatusCode());
    }
}
