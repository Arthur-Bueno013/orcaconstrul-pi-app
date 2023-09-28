<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetalhePedidoController;
use App\Http\Controllers\PedidoController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Rotas Marketplaces
Route::middleware('api')->prefix('pedidos')->group(function () {
    Route::get('/', [PedidoController::class, 'index']);
    Route::post('/', [PedidoController::class, 'store']);
    Route::get('/{pedido}', [PedidoController::class, 'show']);
    Route::put('/{pedido}', [PedidoController::class, 'update']);
    Route::delete('/{pedido}', [PedidoController::class, 'destroy']);
});
//Rotas Marketplacesded
Route::middleware('api')->prefix('detalhespedidos')->group(function () {
    Route::get('/', [DetalhePedidoController::class, 'index']);
    Route::post('/', [DetalhePedidoController::class, 'store']);
    Route::get('/{detalhepedido}', [DetalhePedidoController::class, 'show']);
    Route::put('/{detalhepedido}', [DetalhePedidoController::class, 'update']);
    Route::delete('/{detalhepedido}', [DetalhePedidoController::class, 'destroy']);
});

Route::middleware('api')->prefix('bairros')->group(function () {
    Route::get('/', [BairroController::class, 'index']);
    Route::post('/', [BairroController::class, 'store']);
    Route::get('/{bairro}', [BairroController::class, 'show']);
    Route::put('/{bairro}', [BairroController::class, 'update']);
    Route::delete('/{bairro}', [BairroController::class, 'destroy']);
});
Route::middleware('api')->prefix('metodopagamentos')->group(function () {
    Route::get('/', [MetodoPagamentoController::class, 'index']);
    Route::post('/', [MetodoPagamentoController::class, 'store']);
    Route::get('/{metodopagamento}', [MetodoPagamentoController::class, 'show']);
    Route::put('/{metodopagamento}', [MetodoPagamentoController::class, 'update']);
    Route::delete('/{metodopagamento}', [MetodoPagamentoController::class, 'destroy']);
});


