<?php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource("produtos", ProdutoController::class); //definindo rotas padrões crud para a controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource("clientes", ClienteController::class); //definindo rotas padrões crud para a controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource("servicos", ServicoController::class); //definindo rotas padrões crud para a controller