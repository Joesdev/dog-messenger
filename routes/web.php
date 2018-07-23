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
//Services
use App\Services\ExternalZipApiService;
use App\Services\ExternalPetApiService;

use App\Services\NotificationService;
use App\Services\DogDataService;

Route::get('/', 'BreedController@getHomeView');
Route::post('/submit-form', 'FormController@storeUserSelection');
Route::view('/results', 'results');

Route::get('/results/{email}', 'BreedController@showCollectedArrayOfDogsView');

Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');

//User
Route::delete('/user/{email}', 'UserController@destroyUser')->name('user.delete');
Route::get('/user/zip/{email}', 'UserController@getUserZip');
Route::get('/user/breed/{email}', 'UserController@getUserBreed');
Route::get('/user/miles/{email}', 'UserController@getUserMiles');

//Selection
Route::post('/selection/{breedName}/{zip}/{maxMiles}', 'FormController@storeSelection');
