<?php
/**
 * @package App\Swapi
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   16/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Swapi;

use App\Models\Starship;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use LogicException;

final class Dto implements DtoInterface
{
    public const ACCEPTED_MODELS = [Starship::class, Vehicle::class];

    /**
     * No existe un campo ik o pk para la primary key. Podríamos usar la Url, siendo única.
     * Sacamos el Id de dicha url. Ojo con el slash opcional a final de la Url.
     *
     * @param string $url
     * @return int|null
     */
    public function extractKeyFromUrl(string $url): ?int
    {
        preg_match('`/([A-z]+)/(\d+)([/]{0,1})$`', $url, $matches);

        return (count($matches) >= 3) ? (int)$matches[2] : null;
    }

    /**
     * @param int $pKey
     * @param array $row
     * @param string $model
     * @return Model
     */
    public function findOrCreate(int $pKey, array $row, string $model): Model
    {
        if (!\in_array($model, self::ACCEPTED_MODELS)) {
            throw new LogicException(sprintf('Model %s not found in Dto', $model));
        }

        // Check if in database
        $entity = $model::find($pKey);

        // Podríamos comparar las fechas de edición si alojaríamos los datos en la BBDD.
        // $dt = \DateTime::createFromFormat('Y-m-d\TH:i:s.uZ', $row['edited']);

        // Save in database otherwise
        if (!$entity) {
            $factory = $model::factory();
            $entity = $factory->createFromSwapi($row, $pKey);
            $entity->save();
        }
        return $entity;
    }
}
