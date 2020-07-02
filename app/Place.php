<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['type_id','place_key','name','address'];


    public function type ()
    {
        return $this->hasOne('App\Type');
    }





}
