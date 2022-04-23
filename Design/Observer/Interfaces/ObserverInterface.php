<?php

namespace Design\Observer\Interfaces;

interface ObserverInterface
{
    public function update(float $temp, float $humidity, float $pressure);
}