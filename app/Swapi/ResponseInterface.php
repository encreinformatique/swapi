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

interface ResponseInterface
{
    public function getStatusCode(): int;
    public function getContent(): array;
}
