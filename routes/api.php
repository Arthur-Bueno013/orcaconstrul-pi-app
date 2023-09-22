<?php
use App\Http\Controllers\BairroController;
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

Route::middleware('api')->prefix('bairros')->group(function () {
    Route::get('/', [BairroController::class, 'index']);
    Route::post('/', [BairroController::class, 'store']);
    Route::get('/{bairro}', [BairroController::class, 'show']);
    Route::put('/{bairro}', [BairroController::class, 'update']);
    Route::delete('/{bairro}', [BairroController::class, 'destroy']);
});
