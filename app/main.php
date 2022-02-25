<?php
    declare(strict_types=1);

    require_once './Controllers/WeatherController.php';

    use App\Controller\WeatherController;

    $_ENV['API_URL'] = 'https://api.openweathermap.org/data/2.5/';
    $_ENV['API_BKP'] = 'https://api.openweathermap.org/data/2.5/';
    $_ENV['KEY'] = 'c0f764ce5e4c25576b8d6325fc223810';
    $_ENV['KEY_BKP'] = 'c0f764ce5e4c25576b8d6325fc223810';

    $controllerWeather = new WeatherController();

    print_r(json_decode($controllerWeather->getCityInfo($argv), true)['message']);
    echo "\n";
