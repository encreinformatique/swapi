<?php
/**
 * @package App\Models
 * @author Julien Devergnies <j.devergnies@gmail.com>
 * @date   14/5/24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starship extends Model
{
    use HasFactory;

    public const ENDPOINT_SLUG = 'starships';

    // Mantendremos los valores iniciales de la API.
    // public const CREATED_AT = 'created';
    // public const UPDATED_AT = 'edited';

    /**
     * Agregamos count a la lista de campos.
     * Podemos omitir los otros campos.
     * Mantenemos name y model para agilizar la identificación en la base de datos.
     */
    protected $fillable = [
        'id',
        'name',
        'model',
//        'manufacturer',
//        'cost_in_credits',
//        'length',
//        'max_atmosphering_speed',
//        'crew',
//        'passengers',
//        'cargo_capacity',
//        'consumables',
//        'hyperdrive_rating',
//        'MGLT',
//        'starship_class',
//        'created',
        'edited',
        'count',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * De momento omitimos las relaciones.
     */
//    /**
//     * Get the films that this vehicle has appeared in.
//     */
//    public function films(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//    {
//        return $this->belongsToMany(Film::class);
//    }
//
//    /**
//     * Get the pilots that this vehicle has been piloted by.
//     */
//    public function pilots(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//    {
//        return $this->belongsToMany(Person::class);
//    }
}
