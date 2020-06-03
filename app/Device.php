<?php

namespace App;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use TenantScoped;

    protected $fillable = [ 'name','tel','r','d' ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function fences()
    {
        return $this->belongsToMany(Fence::class,'fence_device');
        #return $this->belongsToMany('App\Fence')->using('App\DeviceFence','fence_device');
    }


}
