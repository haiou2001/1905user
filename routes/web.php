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

Route::get('/user/reg','Api\UserController@reg');
Route::get('/user/login','Api\UserController@login');
Route::get('/user/token','Api\UserController@getData');
Route::get('/user/sign','Api\UserController@sign');
Route::get('/user/sign2','Api\UserController@key_sign');
Route::get('/user/check2','Api\UserController@check2');
Route::get('/user/decrypt','Api\UserController@decrypt');


Route::get('client/goods','Client\ClientController@goods');
Route::get('client/good','Client\ClientController@good');
Route::get('client/rsa','Client\ClientController@rsa');
Route::get('client/sign','Client\ClientController@sign');
Route::get('client/sign2','Client\ClientController@sign2');
