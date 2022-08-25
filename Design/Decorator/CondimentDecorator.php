<?php

namespace Design\Decorator;

use Design\Decorator\Beverage;

abstract class CondimentDecorator extends Beverage
{
    /**
     * Beverage type
     *
     * @var Beverage
     */
    protected $beverage;

    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }
}