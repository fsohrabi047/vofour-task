<?php

namespace Design\Decorator\Condiments;

use Design\Decorator\Beverage;
use Design\Decorator\CondimentDecorator;

class Mocha extends CondimentDecorator
{
    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
        // parent::__construct($beverage);
    }

    /**
     * Get condiment description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->beverage
            ->getDescription() . ' ,Mocha' ;
    }

    /**
     * Add condiment cost to beverage cost
     *
     * @return float
     */
    public function cost() : float
    {
        return $this->beverage
            ->cost() + .20;
    }
}