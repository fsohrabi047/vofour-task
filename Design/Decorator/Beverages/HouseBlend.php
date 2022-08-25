<?php

namespace Design\Decorator\Beverages;

use Design\Decorator\Beverage;

class HouseBlend extends Beverage
{
    public function __construct()
    {
        $this->description = 'House Blend Coffee';
    }

    /**
     * Get house blend coffee cost
     *
     * @return float
     */
    public function cost()
    {
        return 0.89;
    }
}