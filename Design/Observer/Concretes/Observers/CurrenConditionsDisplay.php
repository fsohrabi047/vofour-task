<?php

namespace Design\Observer\Concretes\Observers;

use Design\Observer\Concretes\WeatherData;
use Design\Observer\Interfaces\DisplayElementInterface;
use Design\Observer\Interfaces\ObserverInterface;

class CurrenConditionsDisplay implements ObserverInterface, DisplayElementInterface
{
    private $temperature;
    
    private $humidity;
    
    private WeatherData $weatherData;

    public function __construct(WeatherData $weatherData)
    {
        $this->weatherData = $weatherData;

        $weatherData->registerObserver($this);
    }


    public function update(float $temp, float $humidity, float $pressure)
    {
        $this->temperature = $temp;

        $this->humidity = $humidity;

        return $this->display();
    }

    public function display()
    {
        dump(("Current conditions: {$this->temperature} F degrees and {$this->humidity} % humidity"));
    }
}