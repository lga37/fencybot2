<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['alert_id','place_id',];

    public function alert ()
    {
        return $this->belongsTo('App\Alert');
    }

    public function place ()
    {
        return $this->belongsTo('App\Place');
    }
}
