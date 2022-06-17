<?php
namespace App\Traits;

use App\Traits\Money;


trait HasPrice {

    public function getPriceAttribute ($value)
    {
        return new Money($value);
    }

    public function getFormattedPriceAttribute ()
    {
        return $this->price->formatted();

    }

}
