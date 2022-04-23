<?php

namespace Design\Strategy\Behaviors\Quack;

use Design\Strategy\Interfaces\QuackBehaviorInterface;

class Squack implements QuackBehaviorInterface
{
    public function quack()
    {
        dump('I just squack!!!');
    }
}