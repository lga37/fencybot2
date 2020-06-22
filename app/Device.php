<?php

namespace App;

use Illuminate\Support\Str;
use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use TenantScoped;

    protected $fillable = [ 'name','tel','r','d','t','partners' ];

    protected $casts = [
        'partners' => 'array',
    ];

    public function getPartnersAttribute($v)
    {
        #return $v;
        return Str::contains($v, ',')? explode(',',$v) : [$v];
    }

    public function setPartnersAttribute($v)
    {
        $formatted = trim($v,',');
        #dd($formatted);

        return $formatted;
    }


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
