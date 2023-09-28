<?php

use App\Http\Controllers\NotaFiscalController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UnidadeMedidaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Rotas Tipos
Route::middleware('api')->prefix('tipos')->group(function () {
    Route::get('/', [TipoController::class, 'index']);
    Route::post('/', [TipoController::class, 'store']);
    Route::get('/{tipo}', [TipoController::class, 'show']);
    Route::put('/{tipo}', [TipoController::class, 'update']);
    Route::delete('/{tipo}', [TipoController::class, 'destroy']);
});

//Rotas Produtos
Route::middleware('api')->prefix('produtos')->group(function () {
    Route::get('/', [ProdutoController::class, 'index']);
    Route::post('/', [ProdutoController::class, 'store']);
    Route::get('/{produto}', [ProdutoController::class, 'show']);
    Route::put('/{produto}', [ProdutoController::class, 'update']);
    Route::delete('/{produto}', [ProdutoController::class, 'destroy']);
});

Route::middleware('api')->prefix('unidade_medidas')->group(function () {
    Route::get('/', [UnidadeMedidaController::class, 'index']);
    Route::post('/', [UnidadeMedidaController::class, 'store']);
    Route::delete('/{unidade_medida}', [UnidadeMedidaController::class, 'destroy']);

});

Route::middleware('api')->prefix('nota_fiscals')->group(function () {
    Route::get('/', [NotaFiscalController::class, 'index']);
    Route::post('/', [NotaFiscalControllertroller::class, 'store']);
    Route::delete('/{nota_fiscal', [NotaFiscalController::class, 'destroy']);

});