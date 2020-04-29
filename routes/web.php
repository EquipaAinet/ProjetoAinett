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
Route::get('disciplinas', 'DisciplinaController@index')->name('disciplinas.index');

Route::get('cursos', 'CursoController@index')->name('cursos.index');

Route::get('docentes', 'DocenteController@index')->name('docentes.index');

Route::get('candidaturas', 'CandidaturaController@create')->name('candidaturas.index');
Route::post('candidaturas', 'CandidaturaController@store')->name('candidaturas.store');

// admininstração de disciplinas
Route::get('admin/disciplinas', 'DisciplinaController@admin')->name('admin.disciplinas');
Route::get('admin/disciplinas/{disciplina}/edit', 'DisciplinaController@edit')->name('admin.disciplinas.edit');
Route::get('admin/disciplinas/create', 'DisciplinaController@create')->name('admin.disciplinas.create');
Route::post('admin/disciplinas', 'DisciplinaController@store')->name('admin.disciplinas.store');
Route::put('admin/disciplinas/{disciplina}', 'DisciplinaController@update')->name('admin.disciplinas.update');
Route::delete('admin/disciplinas/{disciplina}', 'DisciplinaController@destroy')->name('admin.disciplinas.destroy');

// dashboard
Route::get('admin', 'DashboardController@index')->name('admin.dashboard');

// admininstração de cursos
Route::get('admin/cursos', 'CursoController@admin')->name('admin.cursos');
Route::get('admin/cursos/{curso}/edit', 'CursoController@edit')->name('admin.cursos.edit');
Route::get('admin/cursos/create', 'CursoController@create')->name('admin.cursos.create');
Route::post('admin/cursos', 'CursoController@store')->name('admin.cursos.store');
Route::put('admin/cursos/{curso}', 'CursoController@update')->name('admin.cursos.update');
Route::delete('admin/cursos/{curso}', 'CursoController@destroy')->name('admin.cursos.destroy');

// admininstração de docentes
Route::get('admin/docentes', 'DocenteController@admin')->name('admin.docentes');
Route::get('admin/docentes/{docente}/edit', 'DocenteController@edit')->name('admin.docentes.edit');
Route::get('admin/docentes/create', 'DocenteController@create')->name('admin.docentes.create');
Route::post('admin/docentes', 'DocenteController@store')->name('admin.docentes.store');
Route::put('admin/docentes/{docente}', 'DocenteController@update')->name('admin.docentes.update');
Route::delete('admin/docentes/{docente}', 'DocenteController@destroy')->name('admin.docentes.destroy');

// admininstração de alunos
Route::get('admin/alunos', 'AlunoController@admin')->name('admin.alunos');
Route::get('admin/alunos/{aluno}/edit', 'AlunoController@edit')->name('admin.alunos.edit');
Route::get('admin/alunos/create', 'AlunoController@create')->name('admin.alunos.create');
Route::post('admin/alunos', 'AlunoController@store')->name('admin.alunos.store');
Route::put('admin/alunos/{aluno}', 'AlunoController@update')->name('admin.alunos.update');
Route::delete('admin/alunos/{aluno}', 'AlunoController@destroy')->name('admin.alunos.destroy');
