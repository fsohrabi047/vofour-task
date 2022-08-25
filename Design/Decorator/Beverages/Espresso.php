<?php

namespace Design\Decorator\Beverages;

use Design\Decorator\Beverage;

class Espresso extends Beverage
{
    public function __construct()
    {
        $this->description = 'Espresso';
    }

    /**
     * Return espresso cost
     *
     * @return float
     */
    public function cost()
    {
        return 1.99;
    }
}