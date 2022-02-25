<?php
    declare(strict_types=1);
    namespace App\Controller;

    require_once '/var/www/Services/GuzzleClient.php';
    require_once '/var/www/UseCases/GetWeatherCity.php';

    use App\Services\GuzzleClient;
    use App\UseCases\GetWeatherCity;

/**
 * Class description
 *
 * @author Albert Ferraté
 * This class represents a controller in layer infrastructure
 */
class WeatherController
{
    /**
     * Property http client implementation
     *
     * @var GuzzleClient
     */
    private $httpClient;
    /**
     * Property use case for getting weather data
     *
     * @var GetWeatherCity
     */
    private $getWeatherCity;

    public function __construct()
    {
        $this->httpClient = new GuzzleClient();
        $this->getWeatherCity = new GetWeatherCity();
    }

    /**
     * Get information of the city
     *
     * This method calls another class in the layer application it calls the use case
     * @param array $args This array contains the needed arguments to retrieve weather data
     * @return string json with data weather
     */
    public function getCityInfo(array $args): string
    {
        $result = $this->getWeatherCity->getInfo($this->httpClient, $args);

        return $result;
    }
}
