<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\Api\IndexController')->name('api.index');
Route::get('/starships', 'App\Http\Controllers\Api\Starships\ListController')->name('api.starships');
Route::get('/vehicles', 'App\Http\Controllers\Api\Vehicles\ListController')->name('api.vehicles');
Route::get('/starships/{id}', 'App\Http\Controllers\Api\Starships\DetailController')
    ->where('id', '\d+')
    ->name('api.starships.detail');
Route::get('/vehicles/{id}', 'App\Http\Controllers\Api\Vehicles\DetailController')
    ->where('id', '\d+')
    ->name('api.vehicles.detail');
/*
 * Rutas para editar
 */
Route::patch('/starships/{id}', 'App\Http\Controllers\Api\Starships\EditController')
    ->where('id', '\d+')
    ->name('api.starships.edit');
Route::patch('/vehicles/{id}', 'App\Http\Controllers\Api\Vehicles\EditController')
    ->where('id', '\d+')
    ->name('api.vehicles.edit');
Route::patch('/starships/{id}/increment', 'App\Http\Controllers\Api\Starships\EditController@increment')
    ->where('id', '\d+')
    ->name('api.starships.increment');
Route::patch('/vehicles/{id}/increment', 'App\Http\Controllers\Api\Vehicles\EditController@increment')
    ->where('id', '\d+')
    ->name('api.vehicles.increment');
Route::patch('/starships/{id}/decrement', 'App\Http\Controllers\Api\Starships\EditController@decrement')
    ->where('id', '\d+')
    ->name('api.starships.increment');
Route::patch('/vehicles/{id}/decrement', 'App\Http\Controllers\Api\Vehicles\EditController@decrement')
    ->where('id', '\d+')
    ->name('api.vehicles.increment');

/*
 * Otras rutas de la API.
 * La ruta schema devuelve un 404. La descartamos.
 */
Route::get('/{endpoint}', 'App\Http\Controllers\Api\OtherController')
    ->where('endpoint', '^(films|people|planets|species)((\/{0,1})|\/\d)')
    ->name('api.other');

/*
 * Mensaje para rutas inexistantes.
 */
Route::fallback(function () {
    return response(['message' => 'I have a bad feeling about this.'], 404);
});
