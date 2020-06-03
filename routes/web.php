<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/adm', function () {
    return view('aaa');
});
*/

/*
Route::middleware('auth')->group(function () {
    Route::group(['namespace' => 'Profile'], function() {
        // view
        Route::view('/profile', 'profile.profile');
        Route::view('/password', 'profile.password');
        // api
        Route::group(['prefix' => 'api/profile'], function() {
            Route::get('/getAuthUser','UserController@getAuthUser');
            Route::put('/updateAuthUser','UserController@updateAuthUser');
            Route::put('/updateAuthUserPassword','UserController@updateAuthUserPassword');
        });
    });
});
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::resource('fencedevice', 'FenceDeviceController', [
    'only' => ['destroy', 'update', 'store']
]);
Route::resource('meet', 'MeetController', [
    'only' => ['destroy', 'index', 'store']
]);
Route::resource('track', 'TrackController', [
    'only' => ['destroy', 'index', 'store']
]);

Route::post('/alert/batch', 'AlertController@batch')->name('alert.batch');
#Route::post('/track/add', 'MeetController@add')->name('fence.add');
#Route::post('/fence/add', 'FenceController@add')->name('fence.add');

Route::group(['prefix' => 'adm', 'middleware' => ['auth']], function () {

    Route::get('/adm', 'HomeController@index')->name('home');
    Route::get('/user/profile', 'UserController@profile')->name('user.profile');
    Route::post('/user/update', 'UserController@update')->name('user.update');
    Route::get('/user/telegram', 'UserController@telegram')->name('user.telegram');

    Route::post('/user/emailchange', 'UserController@emailchange')->name('user.emailchange');

    Route::get('/user/changepass', 'UserController@changepass')->name('user.changepass');
    Route::post('/user/savepass', 'UserController@savepass')->name('user.savepass');
    Route::resource('fence', 'FenceController');
    Route::resource('device', 'DeviceController', [
        'only' => ['destroy', 'update', 'store', 'index', 'show']
    ]);

});

Route::resource('alert', 'AlertController', [
    'only' => ['destroy', 'show', 'store', 'index']
]);


Route::get('/fence/{tel}/get', 'FenceController@getFences')->name('fence.get');
Route::post('/alert/{tel}/post', 'AlertController@postAlerts')->name('alert.post');
Route::post('/alert/{tel}/track', 'AlertController@trackAlerts')->name('alert.track');
