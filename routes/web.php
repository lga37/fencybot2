<?php

use App\Events\EventAlert;
use App\Mail\AlertEmitted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;


Broadcast::routes();

Auth::routes();


Route::get('/', function () { return view('welcome'); });


Route::post('/adm/fence/add', 'FenceController@add')->name('fence.add');

# alerta simples, em lotes
Route::post('/adm/alert/track/{tel}', 'AlertController@track')->name('alert.track');

#puladas de cerca
Route::post('/adm/alert/post/{tel}', 'AlertController@postAlerts')->name('alert.post');

#invasoes
Route::post('/adm/alert/invasion/{tel}', 'AlertController@invasion')->name('alert.invasion');


Route::get('/adm/fence/{tel}/get', 'FenceController@getFences')->name('fence.get');





Route::group(['prefix' => 'adm', 'middleware' => ['auth']], function () {

    Route::get('/adm', 'HomeController@index')->name('home');
    Route::get('/user/profile', 'UserController@profile')->name('user.profile');
    Route::post('/user/update', 'UserController@update')->name('user.update');
    Route::get('/user/notify', 'UserController@notify')->name('user.notify');

    Route::post('/user/emailchange', 'UserController@emailchange')->name('user.emailchange');

    Route::get('/user/changepass', 'UserController@changepass')->name('user.changepass');
    Route::post('/user/savepass', 'UserController@savepass')->name('user.savepass');
    Route::resource('fence', 'FenceController');


    Route::post('/device/configure', 'DeviceController@configure')->name('device.configure');
    Route::resource('device', 'DeviceController', [
        'only' => ['destroy', 'update', 'store', 'index', 'show']
    ]);

    ###################################################
    Route::resource('fencedevice', 'FenceDeviceController', [
        'only' => ['destroy', 'update', 'store']
    ]);

    Route::get('/alert/hist', 'AlertController@hist')->name('alert.hist');
    Route::post('/alert/filter', 'AlertController@filter')->name('alert.filter');
    Route::get('/alert/invasions', 'AlertController@invasions')->name('alert.invasions');
    Route::post('/alert/filterTracks', 'AlertController@filterTracks')->name('alert.filterTracks');

    Route::post('/alert/massDestroy', 'AlertController@massDestroy')->name('alert.massDestroy');


    Route::resource('alert', 'AlertController', [
        'only' => ['destroy', 'store', 'index']
    ]);

});
