<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $casts = [
        'created_at' => 'datetime',
        'dt' => 'datetime',
    ];

    protected $fillable = ['lat','lng','dt','device_id',];

    public function fencedevice ()
    {
        return $this->belongsTo('App\FenceDevice','fencedevice_id','id')->select('fence_id','device_id');
    }

    public function fence_old ()
    {
        return $this->fencedevice()->with('fence:id,name,fence');
    }

    public function fence ()
    {
        return $this->belongsTo('App\Fence');
    }

    public function device_old ()
    {
        return $this->fencedevice()->with('device:id,name');
    }

    public function device ()
    {
        return $this->belongsTo('App\Device');
    }



}
