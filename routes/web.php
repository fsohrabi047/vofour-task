<?php

use Design\Observer\Concretes\Observers\CurrenConditionsDisplay;
use Design\Observer\Concretes\WeatherData;
use Design\Strategy\Behaviors\Fly\FlyNoWays;
use Design\Strategy\MallardDuck;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd('/d.;d.;d.d.d');
});
Route::prefix('patterns')
    ->name('patterns.')
    ->group(function () {

        Route::get('strategy', function (MallardDuck $duck) {
            $duck->performFly();
            $duck->performQuack();
            dump('Set new fly behavior');
            $duck->setFlyBehaviorAttribute(new FlyNoWays);
        
            $duck->performFly();
        });

        Route::get('observer', function (WeatherData $weatherData) {
            $currentConditionDisplay = new CurrenConditionsDisplay($weatherData);
            
            for ($i = 1; $i < rand(3, 6); $i++) {
                $weatherData->setMeasurements(rand(18, 28), rand(20, 28), rand(5, 15));
            }
        });
    });

