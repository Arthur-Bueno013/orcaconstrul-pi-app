<?php

use App\Http\Controllers\BairroController;
use App\Http\Controllers\MetodoPagamentoController;
use App\Http\Controllers\NotaFiscalController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UnidadeMedidaController;
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