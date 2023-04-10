<?php

use App\Http\Controllers\api\CategoriaController;
use App\Http\Controllers\api\MarcaController;
use App\Http\Controllers\api\ProdutoController;
//use Illuminate\Http\Request;
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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */
Route::apiResource('categorias', CategoriaController::class); //Lê a controle e ve se tem os métodos as vincula com os verbos HTTP
Route::apiResource('marcas', MarcaController::class); //Lê a controle e ve se tem os métodos as vincula com os verbos HTTP
Route::apiResource('produtos', ProdutoController::class); //Lê a controle e ve se tem os métodos as vincula com os verbos HTTP
