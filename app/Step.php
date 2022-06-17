<?php

namespace App;

use App\Traits\HasOrder;
use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;


class Step extends Model
{

    use HasOrder, HasPrice;

    protected $fillable = [
        'title',
        'order',
        'price',

    ];

    public static function boot ()
    {
        parent::boot();
        static::creating(function ($step){
            if(is_null($step->order)){
                #$step->order = static::orderBy('order','desc')->first()->order + 1;
                $step->order = $step->ordering()->last();
            }
        });
    }


}
