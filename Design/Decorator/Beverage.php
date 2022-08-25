<?php

namespace Design\Decorator;

abstract class Beverage
{
    /**
     * Beverage description
     *
     * @var string
     */
    protected $description = 'This is delicious beverage';

    /**
     * Get beverage description
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Calculate beverage cost
     *
     * @return float
     */
    abstract public function cost();
}
