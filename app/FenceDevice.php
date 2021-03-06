<?php

namespace App;

use App\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FenceDevice extends Model
{
    use TenantScoped;
    protected $table = 'fence_device';


    public function fence()
    {
        return $this->belongsTo('App\Fence');
    }

    public function device()
    {
        return $this->belongsTo('App\Device');
    }

    public function alerts ()
    {
        return $this->hasMany('App\Alert','fencedevice_id','id');
    }

}
