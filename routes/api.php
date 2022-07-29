<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('ciudades', 'CiudadController@getCiudades');
Route::get('cargos', 'CargoPersonaController@getCargoPersonas');
Route::get('identificacion', 'TipoIdentificacionController@getIdentificaciones');

Route::post('persona', 'PersonaController@insertarPersona');
Route::get('persona', 'PersonaController@obtenerPersonas');
Route::delete('delete-persona/{id}', 'PersonaController@eliminarPersona');
Route::put('editar-persona', 'PersonaController@editarUsuario');
Route::get('getpersona/{id}', 'PersonaController@obtenerPersona');
