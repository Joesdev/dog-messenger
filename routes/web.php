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

Route::post('/create', 'FormController@storeUserSelection');

Route::get('/results/{email}/{token}', 'BreedController@showCollectedArrayOfDogsView');

Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');

//User
Route::delete('/user/{email}/{token}', 'UserController@destroyUser')->name('user.delete');
Route::get('/user/zip/{email}', 'UserController@getUserZip');
Route::get('/user/miles/{email}', 'UserController@getUserMiles');
Route::get('/user/unsubscribe/{email}/{token}', 'UserController@unsubUser');


Route::get('/test/notification/{email}', function($email){
    $notificationService = new \App\Services\NotificationService();
    $notificationService->sendNotification('joesilvpb4@gmail.com');
});