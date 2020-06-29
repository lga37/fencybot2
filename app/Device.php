<?php

namespace App;

use Illuminate\Support\Str;
use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use TenantScoped;

    protected $fillable = ['name', 'tel', 'r', 'd', 't',];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function fences()
    {
        return $this->belongsToMany(Fence::class, 'fence_device');
    }

    public function partners()
    {
        return $this->hasMany(Partner::class, 'device_id','id');
    }


}
