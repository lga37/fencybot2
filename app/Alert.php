<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Alert extends Model
{
    use Notifiable;


    protected $casts = [
        'created_at' => 'datetime',
        'dt' => 'datetime',
    ];

    protected $fillable = ['lat','lng','dt','device_id','fence_id','lat_fence','lng_fence'];

    public function fencedevice ()
    {
        return $this->belongsTo('App\FenceDevice','fencedevice_id','id')->select('fence_id','device_id');
    }

    public function fence ()
    {
        return $this->belongsTo('App\Fence');
    }

    public function device ()
    {
        return $this->belongsTo('App\Device');
    }



}
