<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['alert_id','place_id',];

    public function alert ()
    {
        return $this->hasOne('App\Alert');
    }

    public function place ()
    {
        return $this->hasOne('App\Place');
    }
}
