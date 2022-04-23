<?php

namespace Design\Strategy\Behaviors\Fly;

use Design\Strategy\Interfaces\FlyBehaviorInterface;

class FlyNoWays implements FlyBehaviorInterface
{
    public function fly()
    {
        dump('I can\'t fly any way!!!');
    }
}