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
Route::resource('users', 'UserController');
Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');
		
/*Route::get('/users', 'UserController@index')->name('users');
Route::post('/register_user', 'UserController@store');*/

//PROJECTS
Route::resource('projects', 'ProjectController');
Route::get('/projects/{id}', 'ProjectController@edit')->name('projects.edit');
Route::post('/register_project', 'ProjectController@store');

//DOCUMENTS POR AREA
/*Route::get('/masteer', function() {
    return view('master');
})->name('master');*/

Route::get('/folder/{area}', 'AreaDocumentController@index');#->name('almacen');
Route::get('/folder/{areaId}/{nivel}', 'AreaDocumentController@getFoldersAndFiles');
Route::post('/register_user', 'UserController@store');


/*Auth::routes();
 
Route::get('/home', 'HomeController@index')->name('home');
 
//Roles y Permisos
 
Route::middleware(['auth'])->group(function(){
 
	//Products
	Route::post('products/store', 'ProductController@store')->name('products.store')
		->middleware('permission:products.create');
 
	Route::get('products', 'ProductController@index')->name('products.index')
		->middleware('permission:products.index');
 
	Route::get('products/create', 'ProductController@create')->name('products.create')
		->middleware('permission:products.create');
 
	Route::put('products/{product}', 'ProductController@update')->name('products.update')
		->middleware('permission:products.edit');
 
	Route::get('products/{product}', 'ProductController@show')->name('products.show')
		->middleware('permission:products.show');
 
	Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy')
		->middleware('permission:products.destroy');
 
	Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit')
		->middleware('permission:products.edit'); */

