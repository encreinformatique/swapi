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

use App\Models\Vehicle;

interface SwapiFactoryInterface
{
    public function createFromSwapi(array $data, int $pKey);
}
