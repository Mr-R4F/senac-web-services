<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientesController;
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

//verbo, caminho, ligação
/* Route::get('/sobre', function () {
    return 'OLÁ MUNDO!';
}); */

Route::get('/sobre', [AboutController::class, 'sobre']); //correto pois ao compilar compilar certo
Route::get('/clientes/lista', [ClientesController::class, 'index']); //correto pois ao compilar compilar certo
//pega a hora do server formate e entrega (date)
//json é fixo, normal faz loop
//adaptação da view e controller