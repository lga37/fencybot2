<?php

namespace App;

use App\Traits\InsertOnDuplicateKey;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{

    use InsertOnDuplicateKey;

    protected $fillable = ['type_id','place_key','name','address','lat','lng'];


    public function type ()
    {
        return $this->belongsTo('App\Type');
    }





}
