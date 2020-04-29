<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     //return view('welcome');
//     return view('pages.index');
// });

Route::get('/', 'PageController@index')->name('home');
Route::get('movimentos', 'MovimentoController@index')->name('movimentos.index');
Route::get('estatisticas', 'EstatisticaController@index')->name('estatisticas.index');
Route::get('definicoes', 'DefinicaoController@index')->name('definicoes.index');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
