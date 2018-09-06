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

use App\User as User;
use App\Notifications\PetArrived;

Route::get('/', 'BreedController@getHomeView');
Route::post('/create', 'FormController@storeUserSelection');
Route::view('/results', 'results');

Route::get('/results/{email}/{token}', 'BreedController@showCollectedArrayOfDogsView');

Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');

//User
Route::delete('/user/{email}', 'UserController@destroyUser')->name('user.delete');
Route::get('/user/zip/{email}', 'UserController@getUserZip');
Route::get('/user/breed/{email}', 'UserController@getUserBreed');
Route::get('/user/miles/{email}', 'UserController@getUserMiles');

Route::get('/test/notification/{email}', function($email){
    $user = User::where('email', $email)->first();
    $user->notify(new PetArrived($user, 95492, 100));
    dd('done');
});