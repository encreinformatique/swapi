<?php
/**
 * @package App\Swapi
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Swapi;

use App\Models\Starship;
use App\Models\Vehicle;

final class Normalizer implements NormalizerInterface
{
    protected const RESULT_WOOKIE = 'rcwochuanaoc';

    protected string $endpointSlug = '';
    protected string $model = '';

    public function getEndpointSlug(): string
    {
        return $this->endpointSlug;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        if (\in_array($model, [Starship::class, Vehicle::class])) {
            $this->endpointSlug = $model::ENDPOINT_SLUG;
        }
        return $this;
    }

    public function normalize(array $content, string $format = ''): array
    {
        /*
         * El indice cambia en formato Wookiee.
         */
        $keyResult = ($format === 'wookiee') ? self::RESULT_WOOKIE : 'results';

        /*
         * Solo queremos uno de estos modelos.
         * Y de paso queremos el indice results.
         */
        if (!\in_array($this->getModel(), [Starship::class, Vehicle::class]) || empty($content)) {
            return $content;
        }

        /*
         * Si tenemos un index url, entonces estamos con el objeto del modelo.
         */
        if (!\array_key_exists($keyResult, $content) &&
            \array_key_exists('url', $content)
        ) {
            return $this->normalizeRow($content);
        }

        foreach ($content[$keyResult] as $idx => $row) {
            // Enriquecemos el resultado.
            $content[$keyResult][$idx] = $this->normalizeRow($row);
        }

        return $content;
    }

    public function normalizeRow(array $row): array
    {
        /*
         * No existe un campo ik o pk para la primary key. Podríamos usar la Url, siendo única.
         * Sacamos el Id de dicha url. Ojo con el slash opcional a final de la Url.
         */
        preg_match('`/' . $this->getEndpointSlug() . '/(\d+)([/]{0,1})$`', $row['url'] ?? '', $matches);

        // No pudimos obtener la primary key, dejemos pasar para al menos no romper los resultados.
        if (count($matches) < 2) {
            return $row;
        }

        $pKey = (int)$matches[1];

        // Check if in database
        $entity = $this->getModel()::find($pKey);

        // Podríamos comparar las fechas de edición si alojaríamos los datos en la BBDD.
        // $dt = \DateTime::createFromFormat('Y-m-d\TH:i:s.uZ', $row['edited']);

        // Save in database otherwise
        if (!$entity) {
            $factory = $this->getModel()::factory();
            $entity = $factory->createFromSwapi($row, $pKey);
            $entity->save();
        }

        $row['count'] = $entity?->count ?? 0;

        return $row;
    }
}
