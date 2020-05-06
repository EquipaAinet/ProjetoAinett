<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'PageController@index')->name('pages.index');
Route::get('contas', 'ContaController@index')->name('conta.index')->middleware('auth');
Route::get('movimentos/{conta}', 'MovimentoController@index')->name('movimento.index')->middleware('auth');
Route::get('estatisticas', 'EstatisticaController@index')->name('estatisticas.index')->middleware('auth'); //tem acesso se tiver autenticado
Route::get('definicoes', 'DefinicaoController@index')->name('definicoes.index')->middleware('auth');
Route::get('utilizadores', 'UserController@index')->name('utilizadores.index')->middleware('auth');


//Route::get('menu', function(){
//    return view('layout');
//})->middleware('auth');

Auth::routes(['verify' => true]);//ver se conta esta veridicada

//Route::get('/home', 'HomeController@logout')->name('home');
Route::get('logout', 'Auth\LoginController@logout'); //logout


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
