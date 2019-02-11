<?php

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

Route::get('/', function () {
    return view('welcome');
});

// DATOS EN PAGINA PRINCIPAL DE LOS COMPROMISOS
Route::resource('/', 'CommitmentFrontController');

// PROJECTOS
Route::get('project/{id}', 'CommitmentFrontController@project');

// BACKEND DE COMPROMISOS
Route::resource('commitment', 'CommitmentController');

Route::get('editar/compromiso/{id}', [
	'as'			=>	'compromiso.editar',
	'uses'			=>	'CommitmentController@edit'
]);

Route::get('editar/compromiso/{id}', [
	'as'			=>	'compromiso.editar',
	'uses'			=>	'CommitmentController@edit'
]);

// RUTAS DE LOS OBJETIVOS
Route::resource('objective', 'ObjectiveController');

Route::get('objective/conclude/{id}', 'ObjectiveController@conclude');

// RUTA DE ACCESO A LA ADMINISTRACION DEL TABLERO
Route::resource('dashboard', 'DashboardController');

// RUTAS DE AUTENTICACION
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// RUTAS DE ADMINISTRACION DE USUARIOS
Route::resource('user', 'UserController');

Route::get('editar/usuario/{id}', [
	'as'			=>	'usuarios.editar',
	'uses'			=>	'UserController@edit'
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
