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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//autentificacion quitar los comentarios en produccion

/*Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
*/
Route::get('/home', 'HomeController@index')->name('home');

//USERS
Route::get('/users', 'UserController@index')->name('users');
Route::post('/register_user', 'UserController@store');

//PROJECTS
Route::get('/projects', 'ProjectController@index')->name('projects');
Route::post('/register_project', 'ProjectController@store');

//DOCUMENTS POR AREA
/*Route::get('/masteer', function() {
    return view('master');
})->name('master');*/

Route::get('/folder/almacen', 'AreaDocumentController@index')->name('almacen');
Route::post('/register_user', 'UserController@store');


