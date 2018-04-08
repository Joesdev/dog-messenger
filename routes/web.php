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

Route::view('/', 'welcome');

Route::view('/results', 'results');

Route::get('/results/{userEmail}', 'BreedController@showCollectedArrayOfDogsView');

// Testing--------------------------------------------------------------------------------------------------------------
Route::view('/user-selections', 'user-selections');
Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');

Route::get('/breeds', 'FormController@getAllBreeds');