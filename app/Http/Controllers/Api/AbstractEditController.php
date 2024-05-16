<?php
/**
 * @package App\Http\Controllers\Api
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   16/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api;

use App\Swapi\ClientInterface as SwapiClient;
use App\Swapi\DtoInterface as SwapiDto;
use App\Swapi\NormalizerInterface as SwapiNormalizer;
use App\Swapi\Response as SwapiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SfResponse;

abstract class AbstractEditController extends Controller
{
    protected const ACTION_INCREMENT = 'increment';
    protected const ACTION_DECREMENT = 'decrement';
    //protected const ACTION_CHANGE = 'change';

    abstract protected function getModel(): string;
    abstract protected function requestSwapi(int $id): SwapiResponse;

    public function __construct(
        SwapiClient $httpClient,
        SwapiNormalizer $normalizer,
        protected SwapiDto $dto,
    ) {
        parent::__construct($httpClient, $normalizer);
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $newData = json_decode($request->getContent(), true);
        if (!\array_key_exists('count', $newData) ||
            !\is_int($newData['count'])
        ) {
            return response()->json(
                ['message' => 'count field has not been received or is incorrect.'],
                SfResponse::HTTP_BAD_REQUEST
            );
        }

        $response = $this->requestSwapi($id);
        $swItem = $response->getContent();

        /*
         * Find the Primary Key from Url
         */
        $pKey = $this->dto->extractKeyFromUrl($swItem['url'] ?? '');

        // No pudimos obtener la primary key
        if (!$pKey) {
            return response()->json([], SfResponse::HTTP_NOT_FOUND);
        }

        $statusCode = SfResponse::HTTP_NOT_MODIFIED;
        $entity = $this->dto->findOrCreate($pKey, $swItem, $this->getModel());
        if ($entity->count !== $newData['count']) {
            $entity->setAttribute('count', $newData['count']);
            $entity->save();

            $swItem['count'] = $entity->count;
            $statusCode = $response->getStatusCode();
        }

        return response()->json($swItem, $statusCode);
    }

    /**
     * @param string $action
     * @param int $id
     * @return JsonResponse
     */
    protected function changeCountOn(string $action, int $id): JsonResponse
    {
        $response = $this->requestSwapi($id);
        $swItem = $response->getContent();

        $pKey = $this->dto->extractKeyFromUrl($swItem['url'] ?? '');

        if (!$pKey) {
            return response()->json([], SfResponse::HTTP_NOT_FOUND);
        }

        $entity = $this->dto->findOrCreate($pKey, $swItem, $this->getModel());
        switch ($action) {
            case self::ACTION_INCREMENT:
                $entity->count++;
                break;
            case self::ACTION_DECREMENT:
                $entity->count--;
                break;
            // Default: queda igual. Tampoco ha de pasar.
        }
        $entity->save();

        $swItem['count'] = $entity->count;

        return response()->json($swItem, $response->getStatusCode());
    }
}
