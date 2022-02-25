<?php
    declare(strict_types=1);
    namespace App\UseCases;

    require_once '/var/www/Interfaces/HttpClientInterface.php';

    use App\Interfaces\HttpClientInterface;

/**
 * Class description
 *
 * @author Albert Ferraté
 * This class represents use case of getting weather of city belongs to application layer.
 */
final class GetWeatherCity
{
    const MSG_ERROR = 'city must be alphabetic var, example (php ./main.php weather new-york)' .
        'must have second argument must be string wheater and third must be a city,' .
        'cities with blank spaces should be replaced with - (new york should be new-york)'
    ;

    /**
     * Get information of the city
     *
     * This method gets interface for http client we use interface instead of concrete class for reduce coupling.
     * @param HttpClientInterface $httpClient the client for making http requests.
     * @param array $city needed params for retrieve data.
     * @return string json with data weather.
     */
    public function getInfo(HttpClientInterface $httpClient, array $args): string
    {
        if (!$this->checkParams($args)) {
            return '{"code": 400, "message": "' . self::MSG_ERROR . '"}';
        }

        $city = $this->formatCity($args[array_key_last($args)]);

        return $this->formatResult($httpClient->sendRequestWeather($city));
    }

    /**
     * Check if params are correct.
     *
     * This method checks for params for retrieve data.
     * @param array $args needed params for retrieve data.
     * @return bool return if params are correct or not.
     */
    private function checkParams(array $args): bool
    {
        if (count($args) != 3 || !ctype_alpha(str_replace('-', '', $args[array_key_last($args)])) || $args[array_key_last($args) - 1] !== 'weather') {
            return false;
        }

        return true;
    }

    /**
     * Format city.
     *
     * This method formats city and cleans it.
     * @param string $city city for its formatting.
     * @return string return formatted city.
     */
    private function formatCity(string $city): string
    {
        $city = str_replace('-', ' ', strip_tags($city));

        return trim($city);
    }

    /**
     * Format result.
     *
     * This method formats result in json.
     * @param string $response get response and format it in json.
     * @return string return formatted json.
     */
    private function formatResult(string $response): string
    {
        if (strpos($response, 'Error') !== false) {
            return '{"code":500, "message":"' . $response . '"}';
        }

        $arrayResult = json_decode($response, true);

        $result = $arrayResult['weather'][0]['description'] . ', ' . $arrayResult['main']['temp'] . ' degrees Celsius.';

        return '{"code":200, "message":"' . $result . '"}';
    }
}
