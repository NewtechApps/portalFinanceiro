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


Auth::routes();

Route::get('/', function () { return view('auth.login'); });
Route::get('/mailMessage', function () { return view('auth.mailMessage'); });

Route::get('/home',  'HomeController@index')->name('home');
Route::get('/boleto/{id}', 'HomeController@getDownload');


Route::group(['prefix' => 'usuarios'], function () {
    Route::get('/'        , 'UsersController@index');
    Route::get('perfil'   , 'UsersController@perfil');
    Route::post('create'  , 'UsersController@create');
    Route::post('password', 'UsersController@password');
    Route::delete('delete', 'UsersController@delete');
});

Route::group(['prefix' => 'faleConosco'], function () {
    Route::get('/'           , 'FaleConoscoController@index');
    Route::post('enviarEmail', 'FaleConoscoController@enviar');
});

Route::group(['prefix' => 'param'], function () {
    Route::get('/'      , 'ParametersController@index');
    Route::post('update', 'ParametersController@update');
});




