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

final class Normalizer implements NormalizerInterface
{
    protected const RESULT_WOOKIE = 'rcwochuanaoc';

    protected string $endpointSlug = '';
    protected string $model = '';

    public function __construct(private DtoInterface $dto)
    {}

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        if (\in_array($model, Dto::ACCEPTED_MODELS)) {
            $this->model = $model;
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
        if (!\in_array($this->getModel(), Dto::ACCEPTED_MODELS) || empty($content)) {
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
        $pKey = $this->dto->extractKeyFromUrl($row['url'] ?? '');

        // No pudimos obtener la primary key, dejemos pasar para al menos no romper los resultados.
        if (!$pKey) {
            return $row;
        }

        $entity = $this->dto->findOrCreate($pKey, $row, $this->getModel());

        $row['count'] = $entity->count ?? 0;

        return $row;
    }
}
