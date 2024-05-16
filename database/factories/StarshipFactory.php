<?php
/**
 * @package Database\Factories
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   15/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Database\Factories;

use App\Models\Starship;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Starship>
 */
final class StarshipFactory extends Factory implements SwapiFactoryInterface
{
    public function definition(): array
    {
        return [];
    }

    public function createFromSwapi(array $data, int $pKey): Starship
    {
        return $this->create([
            'id' => $pKey,
            'name' => $data['name'] ?? '',
            'model' => $data['model'] ?? '',
            // Si no tenemos fecha, no ha sido modificado en Swapi.
            'edited' => substr($data['edited'] ?? date('Y-m-d-Y-H-i-s'), 0, 19),
        ]);
    }
}
