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

//Testing Classes
use App\Services\NotificationService;
use App\Services\DogDataService;

Route::view('/', 'welcome');

Route::view('/results', 'results');

Route::get('/results/{userEmail}', 'BreedController@showCollectedArrayOfDogsView');

Route::get('/results/{email}', 'BreedController@showCollectedArrayOfDogsView');

Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');
// Testing--------------------------------------------------------------------------------------------------------------
Route::view('/user-selections', 'user-selections');

Route::get('/check', function(){
    $notificationService = new NotificationService();
    $notificationService->notifyNextTwoEmails();
});

Route::get('/test', 'FormController@testFunction');