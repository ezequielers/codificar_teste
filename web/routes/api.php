<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('armazena')->group(function () {
    Route::get('deputados/{ano}', 'DeputadoController@inserirDadosDeputados');
    Route::get('despesas/{ano}/{mes}', 'DespesaController@inserirDespesasDeputados');
    Route::get('redes', 'RedesController@inserirRedesDeputados');
});

Route::prefix('pesquisa')->group(function () {
    Route::get('lista-despesas/', 'ServicosController@listaDeputadosDespesas');
    Route::get('lista-redes', 'ServicosController@listaRedes');
});
