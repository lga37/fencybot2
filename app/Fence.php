<?php

namespace App;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;

class Fence extends Model
{
    //use TenantScoped; #ta dando pau em add pois o js nao pega o user_id (=0)

    protected $fillable = ['name', 'fence', 'user_id'];

    protected $hidden = ['pivot'];


    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class,'fence_device');
    }
}
