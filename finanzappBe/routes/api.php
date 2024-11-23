<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\IngresoController;

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

//Rutas de autenticación

Route::post('registro', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('presupuestos', [PresupuestoController::class, 'store'])->middleware('auth:sanctum');
Route::get('presupuestos', [PresupuestoController::class, 'index'])->middleware('auth:sanctum');
Route::post('presupuestos/{id}/restar', [PresupuestoController::class, 'restar'])->middleware('auth:sanctum');
Route::delete('presupuestos/{id}', [PresupuestoController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('pagos', [PagoController::class, 'index'])->middleware('auth:sanctum');
Route::post('pagos', [PagoController::class, 'store']) ->middleware('auth:sanctum');
Route::get('pagos/{id}', [PagoController::class, 'show']) ->middleware('auth:sanctum'); ;
Route::delete('pagos/{id}', [PagoController::class, 'destroy']) ->middleware('auth:sanctum');
Route::put('pagos/{id}/estado', [PagoController::class, 'updateEstado']) ->middleware('auth:sanctum');

Route::get('movimientos', [MovimientoController::class, 'index'])->middleware('auth:sanctum');
Route::post('movimientos', [MovimientoController::class, 'store'])->middleware('auth:sanctum');
Route::get('movimientos/{id}', [MovimientoController::class, 'show'])->middleware('auth:sanctum');
Route::delete('movimientos/{id}', [MovimientoController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('ingresos', [IngresoController::class, 'index'])->middleware('auth:sanctum');
Route::post('ingresos', [IngresoController::class, 'store'])->middleware('auth:sanctum');
Route::get('ingresos/{id}', [IngresoController::class, 'show'])->middleware('auth:sanctum');
Route::delete('ingresos/{id}', [IngresoController::class, 'destroy'])->middleware('auth:sanctum');

