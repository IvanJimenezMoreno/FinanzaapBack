<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PresupuestoController;

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

