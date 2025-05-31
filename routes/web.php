<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeAdmController; // Importar a nova AdmController
use App\Http\Middleware\RoleAdmMiddleware;
use App\Http\Middleware\RoleAtdMiddleware; // Presumindo que você terá este middleware
use App\Http\Middleware\RoleTecMiddleware; // Presumindo que você terá este middleware
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

// Rotas públicas
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get("/cadastro", [UserController::class, 'create'])->name('cadastro');
Route::post("/cadastro", [UserController::class, 'store']);
Route::get("/login", [AuthController::class, 'showFormLogin'])->name('login');
Route::post("/login", [AuthController::class, 'login']);

Route::middleware("auth")->group(function () {

    //create routes
    Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->middleware('role.adm')->name('funcionarios.create');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->middleware('role.adm')->name('clientes.create');
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->middleware('role.adm')->name('produtos.create');
    Route::get('/servicos/create', [ServicoController::class, 'create'])->middleware('role.adm')->name('servicos.create');
    Route::get('/orcamentos/create', [OrcamentoController::class, 'create'])->middleware('role.adm')->name('orcamentos.create');

    //rotas para todos tipos de users
    Route::post("/logout", [AuthController::class, "logout"])->middleware('auth');
    Route::get("/editar", [UserController::class, 'edit'])->middleware('auth');
    Route::post("/editar", [UserController::class, 'update'])->middleware('auth');

    Route::get('/orcamentos', [OrcamentoController::class, 'index'])->name('orcamentos.index');
    Route::get('/orcamentos/{o}', [OrcamentoController::class, 'show'])->name('orcamentos.show');
    Route::get('/orcamentos/{o}/edit', [OrcamentoController::class, 'edit'])->name('orcamentos.edit');
    Route::put('/orcamentos/{o}', [OrcamentoController::class, 'update'])->name('orcamentos.update');
    
    Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');
    Route::get('/servicos/{s}', [ServicoController::class, 'show'])->name('servicos.show');
    Route::get('/servicos/{s}/edit', [ServicoController::class, 'edit'])->name('servicos.edit');
    Route::put('/servicos/{s}', [ServicoController::class, 'update'])->name('servicos.update');

    //rotas do ADM
     Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionarios.store');
        Route::get('/funcionarios', [FuncionarioController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/{f}', [FuncionarioController::class, 'show'])->name('funcionarios.show');
        Route::get('/funcionarios/{f}/edit', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');
        Route::put('/funcionarios/{f}', [FuncionarioController::class, 'update'])->name('funcionarios.update');
        Route::delete('/funcionarios/{f}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
    });

    Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/{c}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/clientes/{c}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{c}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/clientes/{c}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });

    Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/produtos/{p}', [ProdutoController::class, 'show'])->name('produtos.show');
        Route::get('/produtos/{p}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::put('/produtos/{p}', [ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/produtos/{p}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    });

    Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::post('/servicos', [ServicoController::class, 'store'])->name('servicos.store');
        Route::delete('/servicos/{s}', [ServicoController::class, 'destroy'])->name('servicos.destroy');
    });

    Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::post('/orcamentos', [OrcamentoController::class, 'store'])->name('orcamentos.store');  
        Route::delete('/orcamentos/{o}', [OrcamentoController::class, 'destroy'])->name('orcamentos.destroy');
    });

    Route::middleware([RoleAdmMiddleware::class])->group(function () {
        Route::get('/home-adm', [HomeAdmController::class, 'index'])->name('home.adm');
    });

});