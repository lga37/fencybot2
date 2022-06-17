<?php

use App\Step;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;


Route::get('/steps',function(){
    return Step::orderBy('order','asc')->get();
});
Route::get('/steps/refresh',function(){
    return Step::orderBy('order','asc')->get()->each(function($step,$index){
        $step->update([
            'order'=>$index+1
        ]);
    });
});

Route::get('/steps/update',function(){
    $step = Step::find(1)->ordering()->before();
    Step::find(4)->update([
        'title'=> '2222newwwww',
        'order' => $step,
    ]);
});


#######################################

Route::get('/u',function(){
    $u = User::find(5);
    $u->update([
        'name'=> Str::random(10),
    ]);
    echo 'kkkkkkkkk';
});

Route::get('/u/{user}/history',function(User $u){
    $u = User::find(5);
    return view('user.history',[
        'histories' => $u->history,
    ]);
});




Auth::routes();

Route::get('/adm/lang/{locale}',function($lang){
    Session::put('locale',$lang);

    return redirect()->back();
});




#Route::group(['middleware'=>'language'],function (){

    Route::get('/', function () { return view('welcome'); });
    Route::post('/adm/fence/add', 'FenceController@add')->name('fence.add');

    Route::group(['prefix' => 'adm', 'middleware' => ['auth','language']], function () {

        Route::get('/adm', 'HomeController@index')->name('home');
        Route::get('/user/profile', 'UserController@profile')->name('user.profile');
        Route::post('/user/update', 'UserController@update')->name('user.update');
        Route::get('/user/notify', 'UserController@notify')->name('user.notify');
        Route::post('/user/emailchange', 'UserController@emailchange')->name('user.emailchange');
        Route::get('/user/changepass', 'UserController@changepass')->name('user.changepass');
        Route::post('/user/savepass', 'UserController@savepass')->name('user.savepass');
        Route::resource('fence', 'FenceController');

        Route::resource('type', 'TypeController');
        Route::resource('place', 'PlaceController');

        Route::post('/device/configure', 'DeviceController@configure')->name('device.configure');
        Route::post('/device/patch/{device}', 'DeviceController@patch')->name('device.patch');
        Route::post('/device/untrack/{device}', 'DeviceController@untrack')->name('device.untrack');

        Route::resource('device', 'DeviceController', [
            'only' => ['destroy', 'update', 'store', 'index', 'show']
        ]);

        ###################################################
        Route::resource('fencedevice', 'FenceDeviceController', [
            'only' => ['destroy', 'update', 'store']
        ]);

        Route::get('/alert/inform', 'AlertController@inform')->name('alert.inform');
        Route::post('/alert/warn', 'AlertController@warn')->name('alert.warn');

        Route::get('/alert/hist', 'AlertController@hist')->name('alert.hist');
        Route::post('/alert/filter', 'AlertController@filter')->name('alert.filter');
        Route::get('/alert/invasions', 'AlertController@invasions')->name('alert.invasions');
        Route::post('/alert/filterTracks', 'AlertController@filterTracks')->name('alert.filterTracks');

        Route::post('/alert/massDestroy', 'AlertController@massDestroy')->name('alert.massDestroy');

        Route::get('/alert/parse/{device_id}', 'AlertController@parse')->name('alert.parse');
        Route::resource('alert', 'AlertController', [
            'only' => ['destroy', 'store', 'index',]
        ]);
    });


#});





# alerta simples, em lotes
Route::post('/adm/alert/track/{tel}', 'AlertController@track')->name('alert.track');
#puladas de cerca
Route::post('/adm/alert/post/{tel}', 'AlertController@postAlerts')->name('alert.post');
#invasoes
Route::post('/adm/alert/invasion/{tel}', 'AlertController@invasion')->name('alert.invasion');
#get fences
Route::get('/adm/fence/{tel}/get', 'FenceController@getFences')->name('fence.get');
