<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public const ENDPOINT_SLUG = 'vehicles';

    /**
     * Agregamos count a la lista de campos.
     * Podemos omitir los otros campos.
     * Mantenemos name y model para agilizar la identificación en la base de datos.
     */
    protected $fillable = [
        'id',
        'name',
        'model',
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
}
