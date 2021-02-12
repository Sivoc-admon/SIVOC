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
})->name('home')->middleware('auth');*/

Route::get('/home', 'HomeController@index')->name('home');

//USERS
Route::resource('users', 'UserController');
Route::post('/register_user', 'UserController@store');
Route::delete('/users/detele/{id}', 'UserController@destroy')->name('users.destroy');
Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');;


//PROJECTS
Route::post('projects/board/createBoard', 'ProjectController@createBoard')->name('projects.createBoard');
Route::get('projects/board/showBoards/{tablero}', 'ProjectController@showBoards');
Route::resource('projects', 'ProjectController');
Route::get('/projects/{id}', 'ProjectController@edit')->name('projects.edit');
Route::post('/register_project', 'ProjectController@store');
Route::get('projects/board/showBoards/{tablero}', 'ProjectController@showBoards');

//INDICADORES
Route::resource('indicators', 'IndicatorController');
//Route::get('/indicators', 'IndicatorController@index');
Route::post('/indicators/create', 'IndicatorController@store');
Route::post('/indicators/create/typeIndicator', 'IndicatorController@createIndicatorType');
Route::post('/indicators/create/minMax', 'IndicatorController@getMinMax');
Route::post('/indicators/grafica', 'IndicatorController@graph');

//DOCUMENTS POR AREA
/*Route::get('/masteer', function() {
    return view('master');
})->name('master');*/

Route::get('/folder/{area}', 'AreaDocumentController@index');#->name('almacen');
Route::get('/folder2/{area}/{filesLevelZero}', 'AreaDocumentController@filesLevelZero');#->name('almacen');
Route::get('/folder/{areaId}/{nivel}/{idPadre}', 'AreaDocumentController@getFoldersAndFiles');
Route::post('/folder/create/{areaId}/{nivel}', 'AreaDocumentController@createFolder');
Route::post('/folder/update/{folderId}', 'AreaDocumentController@updateFolder');
Route::post('/file/create/{areaId}/{nivel}', 'AreaDocumentController@createFiles');
Route::post('/file/delete', 'AreaDocumentController@deleteFile');
Route::get('/file/download/{documentId}/{idFolder}', 'AreaDocumentController@downloadFile');

//CLIENTES
Route::post('customers/store', 'CustomerController@store');
Route::delete('customers/{customer}', 'CustomerController@destroy')->name('customers.destroy');
Route::resource('customers', 'CustomerController');

//NORMAS
Route::post('rules/store', 'RuleController@store');
Route::delete('rules/{rule}', 'RuleController@destroy')->name('rules.destroy');
Route::resource('rules', 'RuleController');




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

