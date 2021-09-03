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

Route::get('/', 'HomeController@index')->name('home');
Route::post('/cards-factory', 'CardController@storeFactory');
Route::post('/cards-if', 'CardController@storeIfStatements');

Route::patch('/cards-factory/{card}', 'CardController@patchFactory');
Route::patch('/cards-if/{card}', 'CardController@patchIfStatements');
