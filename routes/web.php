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

Auth::routes();
Route::get('/ajaxConsulta', 'PlacetopayController@prueba');
Route::resource('ordenes','OrdersController');
Route::post('OrdenCheckout', ['as' => 'ordenes.checkout', 'uses' => 'OrdersController@checkout']);
Route::get('/home', 'HomeController@index')->name('home');
