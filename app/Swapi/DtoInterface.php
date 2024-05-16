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

use Illuminate\Database\Eloquent\Model;

interface DtoInterface
{
    public function extractKeyFromUrl(string $url): ?int;
    public function findOrCreate(int $pKey, array $row, string $model): Model;
}
