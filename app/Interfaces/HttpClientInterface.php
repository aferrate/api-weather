<?php
    declare(strict_types=1);

    namespace App\Interfaces;

/**
 * Class description
 *
 * @author Albert Ferraté
 * This class represents the contract for requesting weather
 */
interface HttpClientInterface
{
    /**
     * Get information of the city
     *
     * This method gets city and returns a response with data
     * @param string $city this var contains the city formatted
     * @return string json with data weather
     */
    public function sendRequestWeather(string $city): string;
}
