<?php

use App\Broadcasting\AlertChannel;

use Illuminate\Support\Facades\Broadcast;

#Broadcast::channel('App.User.{id}', function ($user, $id) {
    #dd('Broadcast::channel');
    #return true;
#    return (int) $user->id === (int) $id;
#});

#Broadcast::channel('canal', function () {
#    return true;
    #dd('rotessssssssss');
    //return Auth::check();
#});


#Broadcast::channel('order.{order}', AlertChannel::class);
