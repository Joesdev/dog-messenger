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

Route::get('/', 'Controller@getHomeView');

Route::get('/save', 'BreedStatusController@getCollectedArrayOfDogsView');

Route::view('/results', 'results');

Route::get('/results/{userEmail}', 'BreedStatusController@getCollectedArrayOfDogsView');