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

Route::view('/', 'welcome')->name('landing');
Route::post('/', 'FormController@storeUserSelection')->name('user.create');

Route::view('/results', 'results');

Route::get('/results/{userEmail}', 'BreedController@showCollectedArrayOfDogsView');

Route::get('/results/{email}', 'BreedController@showCollectedArrayOfDogsView');

Route::post('/user-selections', 'FormController@storeUserSelection')->name('user-selections.store');

//User
Route::get('/user/zip/{email}', 'UserController@getUserZip');
Route::get('/user/breed/{email}', 'UserController@getUserBreed');
Route::get('/user/miles/{email}', 'UserController@getUserMiles');

//Selection
Route::post('/selection/{breedName}/{zip}/{maxMiles}', 'FormController@storeSelection');
// Testing--------------------------------------------------------------------------------------------------------------

Route::get('getUpdate', function(){
   $petApiService = new ExternalPetApiService();
   $zipApiService = new ExternalZipApiService();
   $dogDataService = new DogDataService($petApiService, $zipApiService);
   $dogDataService->getUpdatedBreedArray('joesilvpb4@gmail.com');
});

Route::get('/sendNotification', function(){
   $service = new NotificationService();
   $service->sendNotification('joesilvpb4@gmail.com');
});