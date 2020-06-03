<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{

    protected $fillable = ['coords','dt','device_id'];

    public function tracks ()
    {
        return $this->hasMany('App\Track');
    }
    public function device ()
    {
        return $this->belongsTo('App\Device');
    }

}
