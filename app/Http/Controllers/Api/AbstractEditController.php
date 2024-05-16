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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SfResponse;

abstract class AbstractEditController extends Controller
{
    protected const ACTION_INCREMENT = 'increment';
    protected const ACTION_DECREMENT = 'decrement';
    //protected const ACTION_CHANGE = 'change';
    const KEY_NUMBER_INVENTORY = 'count';

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
        $newInventory = $this->computeNumberFromRequest($request);
        if (!$newInventory) {
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
        if ($entity->count !== $newInventory) {
            $entity->setAttribute(self::KEY_NUMBER_INVENTORY, $newInventory);
            // @todo: mover la verificación al evento updating.
            $this->forbidSubZeroInventory($entity);
            $entity->save();

            $swItem[self::KEY_NUMBER_INVENTORY] = $entity->count;
            $statusCode = $response->getStatusCode();
        }

        return response()->json($swItem, $statusCode);
    }

    /**
     * Podríamos usar un numéro negativo/positivo en vez de usar la variable action para definir si sumamos o restamos.
     *
     * @param string $action
     * @param int $id
     * @param int $number    Número a restar/sumar al inventorio.
     * @return JsonResponse
     */
    protected function changeCountOn(string $action, int $id, int $number): JsonResponse
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
                $entity->count+= $number;
                break;
            case self::ACTION_DECREMENT:
                $entity->count-= $number;
                break;
            // Default: queda igual. Tampoco ha de pasar.
        }
        $this->forbidSubZeroInventory($entity);
        $entity->save();

        $swItem[self::KEY_NUMBER_INVENTORY] = $entity->count;

        return response()->json($swItem, $response->getStatusCode());
    }

    /**
     * @todo: mover la verificación al evento updating.
     *
     * @param Model $entity
     * @return void
     */
    protected function forbidSubZeroInventory(Model $entity): void
    {
        if ($entity->count < 0) {
            $entity->setAttribute(self::KEY_NUMBER_INVENTORY, 0);
        }
    }

    protected function computeNumberFromRequest(Request $request): ?int
    {
        $newData = json_decode($request->getContent(), true);
        if (!\array_key_exists(self::KEY_NUMBER_INVENTORY, $newData ?? []) ||
            !\is_int($newData[self::KEY_NUMBER_INVENTORY])
        ) {
            return null;
        }
        return $newData[self::KEY_NUMBER_INVENTORY];
    }
}
