<?php

namespace Design\Strategy\Behaviors\Quack;

use Design\Strategy\Interfaces\QuackBehaviorInterface;

class MuteQuack implements QuackBehaviorInterface
{
    public function quack()
    {
        dump('I am muted duck!!!!');
    }
}