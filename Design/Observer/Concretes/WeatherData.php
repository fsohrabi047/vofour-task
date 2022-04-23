<?php
namespace Design\Observer\Concretes;

use Design\Observer\Interfaces\ObserverInterface;
use Design\Observer\Interfaces\SubjectInterface;

class WeatherData implements SubjectInterface
{
    private $observers = [];
    
    private float $temp;
    
    private float $humidity;
    
    private float $pressure;

    public function registerObserver(ObserverInterface $observer)
    {
        array_push($this->observers, $observer);
    }

    public function removeObserver(ObserverInterface $observer)
    {
        unset($this->observers[$observer]); // Reform this
    }

    public function notifyOservers()
    {
        foreach($this->observers as $observer) {
            $observer->update($this->temp, $this->humidity, $this->pressure);
        }
    }

    public function measurementsChanged()
    {
        return $this->notifyOservers();
    }

    public function setMeasurements(float $temp, float $humidity, float $pressure)
    {
        $this->temp = $temp;

        $this->humidity = $humidity;

        $this->pressure = $pressure;

        return $this->measurementsChanged();
    }
}