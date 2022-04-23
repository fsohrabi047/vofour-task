<?php

namespace Design\Strategy\Behaviors\Fly;

use Design\Strategy\Interfaces\FlyBehaviorInterface;

class FlyWithWings implements FlyBehaviorInterface
{
    public function fly()
    {
        dump('I can fly with my wings!!!');
    }
}