<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable=['fence_id','meet_id','dt','dist'];

    public function meet ()
    {
        return $this->belongsTo('App\Meet');
    }

    public function fence ()
    {
        return $this->belongsTo('App\Fence');
    }

    public function device ()
    {
        return $this->belongsTo('App\Device');
    }


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m H:i:s');

    }


}
