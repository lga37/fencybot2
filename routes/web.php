<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () { return view('welcome'); });

Route::resource('meet', 'MeetController', [
    'only' => ['destroy', 'index', 'store']
]);

Route::post('/adm/fence/add', 'FenceController@add')->name('fence.add');

# alerta simples, em lotes
Route::post('/adm/alert/batch/{tel}', 'AlertController@batch')->name('alert.batch');

#puladas de cerca
Route::post('/adm/alert/post/{tel}', 'AlertController@postAlerts')->name('alert.post');
#Route::post('/adm/alert/{tel}/post', 'AlertController@postAlerts')->name('alert.post');

Route::post('/adm/alert/track', 'MeetController@add')->name('fence.add');
Route::post('/adm/alert/{tel}/track', 'AlertController@trackAlerts')->name('alert.track');

Route::get('/adm/fence/{tel}/get', 'FenceController@getFences')->name('fence.get');


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

    ###################################################
    Route::resource('fencedevice', 'FenceDeviceController', [
        'only' => ['destroy', 'update', 'store']
    ]);

    Route::resource('alert', 'AlertController', [
        'only' => ['destroy', 'show', 'store', 'index']
    ]);

});
