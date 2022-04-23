<?php

namespace Design\Observer\Interfaces;

use Design\Observer\Interfaces\ObserverInterface;


interface SubjectInterface
{
    public function registerObserver(ObserverInterface $observer);

    public function removeObserver(ObserverInterface $observer);

    public function notifyOservers();
}