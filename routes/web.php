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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/logs/save', 'HomeController@logSave');
Route::post('/logs/load/by/id', 'HomeController@logLoadById');
Route::post('/logs/load/by/name', 'HomeController@logLoadByName');
