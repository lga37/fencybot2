<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable=['device_id','partner_id'];


    public function device()
    {
        return $this->belongsTo(Device::class, 'partner_id','id');
    }




}
