<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\empresasController;
use App\Http\Controllers\contactoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/consultarContactos', [contactoController::class, 'listarContactos']);
Route::post('/agregarContacto', [contactoController::class, 'agregarContacto']);
Route::post('/editarContacto', [contactoController::class, 'editarContacto']);
Route::post('/eliminarContacto', [contactoController::class, 'eliminarContacto']);

Route::get('/consultar', [empresasController::class, 'listarEmpresas']);
Route::post('/agregar', [empresasController::class, 'agregarEmpresa']);
Route::post('/editar', [empresasController::class, 'editarEmpresa']);
Route::get('/eliminar', [empresasController::class, 'eliminarEmpresa']);


