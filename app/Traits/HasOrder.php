<?php

namespace App\Traits;

use App\Traits\Orderer;

trait HasOrder
{

    public function ordering () #nao pode chamar de order
    {
        return new Orderer($this);
    }



}
