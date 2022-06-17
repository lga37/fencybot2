<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['changed_column','changed_value_from','changed_value_to',];

}
