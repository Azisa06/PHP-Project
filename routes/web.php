<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\HomeAdmController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\RoleAdmMiddleware;
use App\Http\Middleware\RoleAtdMiddleware;
use App\Http\Middleware\RoleTecMiddleware;
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

/*Route::resource("produtos", ProdutoController::class); //definindo rotas padrões crud para a controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource("clientes", ClienteController::class); //definindo rotas padrões crud para a controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource("funcionarios", FuncionarioController::class); //definindo rotas padrões crud para a controller

Route::get('/', function () {
    return view('welcome');
});

Route::resource("servicos", ServicoController::class); //definindo rotas padrões crud para a controller*/

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::get("/cadastro", [UserController::class, 'create']);
Route::post("/cadastro", [UserController::class, 'store']);

Route::get("/login", [AuthController::class, 'showFormLogin'])->name('login');
Route::post("/login", [AuthController::class, 'login']);

Route::middleware("auth")->group(function (){
    Route::post("/logout", [AuthController::class, "logout"]);
    Route::get("/editar", [UserController:: class, 'edit']);
    Route::post("/editar", [UserController::class, 'update']);

    Route::middleware([RoleAdmMiddleware::class])->group(function (){ 
        Route::resource("clientes", ClienteController::class);
        Route::resource("funcionarios", FuncionarioController::class);
        Route::resource("produtos", ProdutoController::class);
        Route::resource("servicos", ServicoController::class);
        Route::get('/home-adm', [HomeAdmController::class, 'index'])->middleware(['auth', RoleAdmMiddleware::class]);
    });

    Route::middleware([RoleAtdMiddleware::class])->group(function (){ 
        Route::resource("clientes", ClienteController::class);
        Route::resource("produtos", ProdutoController::class);
        Route::resource("servicos", ServicoController::class);
        Route::get('/home-atd', function() {
            return view("home-atd");
        });
    });

    Route::middleware([RoleTecMiddleware::class])->group(function (){ 
        Route::resource("produtos", ProdutoController::class);
        Route::resource("servicos", servicoController::class);
        Route::get('/home-tec', function() {
            return view("home-tec");
        });
    });
});