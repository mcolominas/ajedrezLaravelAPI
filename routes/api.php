<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$path = "Api\\Ajedrez\\Controllers\\";
Route::get('/usuarios/login', $path.'UsuariosController@login');
Route::get('/usuarios/logout', $path.'UsuariosController@logout');
Route::get('/usuarios/verConectados', $path.'UsuariosController@verConectados');

Route::get('/invitacion/invitar', $path.'InvitacionController@invitar');
Route::get('/invitacion/ver', $path.'InvitacionController@ver');
Route::get('/invitacion/responder', $path.'InvitacionController@responder');

Route::get('/tablero/ver', $path.'TableroController@ver');
Route::get('/tablero/mover', $path.'TableroController@moverFicha');

/*
|--------------------------------------------------------------------------
| Parametros para las rutas:
|--------------------------------------------------------------------------
|	Login -> params: email, password
|	logout -> params: token
|	verConectados -> params: token
|
|	invitar -> params: token, name
|	ver -> params: token
|	responder -> params: token, name, respuesta (0,1)
|
|	ver -> params: token, name
|	mover -> params: token, name, toFila, toColumna, fromFila, fromColumna
|
*/