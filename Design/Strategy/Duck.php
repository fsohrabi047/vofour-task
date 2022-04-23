<?php

namespace Design\Strategy;

use Design\Strategy\Interfaces\FlyBehaviorInterface;
use Design\Strategy\Interfaces\QuackBehaviorInterface;

abstract class Duck
{
    protected $flyBehavior;

    protected $quackBehavior;

    public function __construct()
    {
        //
    }

    // public function setFlyBehaviorAttribute(FlyBehaviorInterface $flyBehaviorInterface)
    // {
    //     $this->flyBehavior = $flyBehaviorInterface;
    // }

    // public function setQuackBehaviorAttribute(QuackBehaviorInterface $quackBehaviorInterface)
    // {
    //     $this->quackBehavior = $quackBehaviorInterface;
    // }

    public function performQuack()
    {
        $this->quackBehavior->quack();
    }

    public function performFly()
    {
        $this->flyBehavior->fly();
    }

    public function display()
    {
        //
    }

    public function swim()
    {
        //
    }
}