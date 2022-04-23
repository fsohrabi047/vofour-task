<?php

namespace Design\Strategy\Behaviors\Quack;

use Design\Strategy\Interfaces\QuackBehaviorInterface;

class Quack implements QuackBehaviorInterface
{
    public function quack()
    {
        dump('I can quack!!!');
    }
}