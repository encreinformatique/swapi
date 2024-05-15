<?php
/**
 * @package App\Http\Controllers\Api
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   14/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

final class IndexController extends Controller
{
    public function __invoke(): array
    {
        return [
            'films' => route('api.other', ['endpoint' => 'films']),
            'people' => route('api.other', ['endpoint' => 'people']),
            'planets' => route('api.other', ['endpoint' => 'planets']),
            'species' => route('api.other', ['endpoint' => 'species']),
            'vehicles' => route('api.vehicles'),
            'starships' => route('api.starships'),
        ];
    }
}
