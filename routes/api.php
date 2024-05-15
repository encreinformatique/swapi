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
