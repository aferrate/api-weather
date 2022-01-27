<?php
    declare(strict_types=1);
    
    require_once(getenv('SITE_ROOT')."/Controllers/WeatherController.php");

    use App\Controller\WeatherController;

    $controllerWeather = new WeatherController();

    print_r(json_decode($controllerWeather->getCityInfo($argv), true)['message']);
    echo "\n";
