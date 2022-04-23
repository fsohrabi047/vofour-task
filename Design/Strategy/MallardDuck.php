<?php

namespace Design\Strategy;

use Design\Strategy\Behaviors\Fly\FlyWithWings;
use Design\Strategy\Behaviors\Quack\Quack;
use Design\Strategy\Duck;
use Design\Strategy\Interfaces\FlyBehaviorInterface;
use Design\Strategy\Interfaces\QuackBehaviorInterface;

class MallardDuck extends Duck
{
    public function __construct()
    {
        $this->flyBehavior = new FlyWithWings();

        $this->quackBehavior = new Quack();

    }

    public function setFlyBehaviorAttribute(FlyBehaviorInterface $flyBehaviorInterface)
    {
        $this->flyBehavior = $flyBehaviorInterface;
    }

    public function setQuackBehaviorAttribute(QuackBehaviorInterface $quackBehaviorInterface)
    {
        $this->quackBehavior = $quackBehaviorInterface;
    }
}