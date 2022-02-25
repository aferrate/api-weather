<?php
    declare(strict_types=1);
    namespace App\Tests;

    require_once '/var/www/Controllers/WeatherController.php';

    use PHPUnit\Framework\TestCase;
    use App\Controller\WeatherController;

/**
 * Class description
 *
 * @author Albert Ferraté
 * This class is for testing
 */
final class TestWeather extends TestCase
{
    /**
     * Property WeatherController for getting data and make assertions
     *
     * @var WeatherController
     */
    private $controllerWeather;

    protected function setUp(): void
    {
        $this->controllerWeather = new WeatherController();
    }

    /**
     * Test a request with all parameters correct.
     *
     * This method tests response with all parameters correct
     */
    public function testAllParametersCorrect(): void
    {
        $result = json_decode($this->controllerWeather->getCityInfo(['./main.php', 'weather', 'new-york']), true)['code'];

        $this->assertEquals($result, 200);
    }

    /**
     * Test a request with second parameter wrong.
     *
     * This method tests response with incorrect second parameter.
     */
    public function testSecondParameterWrong(): void
    {
        $result = $this->controllerWeather->getCityInfo(['./main.php', 'weathr', 'new-york']);

        $this->assertEquals($result, '{"code": 400, "message": "city must be alphabetic var' .
            ', example (php ./main.php weather new-york)must have second argument must be string wheater' .
            ' and third must be a city,cities with blank spaces should be replaced with - (new york should be new-york)"}');
    }

    /**
     * Test a request with wrong parameters amount.
     *
     * This method tests response with incorrect amount of parameters.
     */
    public function testWrongAmountParams(): void
    {
        $result = $this->controllerWeather->getCityInfo(['./main.php', 'new-york']);

        $this->assertEquals($result, '{"code": 400, "message": "city must be alphabetic var' .
            ', example (php ./main.php weather new-york)must have second argument must be string wheater' .
            ' and third must be a city,cities with blank spaces should be replaced with - (new york should be new-york)"}');
    }

    /**
     * Test a request with non existent city.
     *
     * This method tests response with non existent city.
     */
    public function testNonExistentCity(): void
    {
        $result = $this->controllerWeather->getCityInfo(['./main.php', 'weather', 'new-yofdgdfgdfrk']);

        $this->assertEquals($result, '{"code":500, "message":"Error: city not found"}');
    }

    /**
     * Test a request with wrong API key.
     *
     * This method tests response with wrong API key.
     */
    public function testWrongApiKey(): void
    {
        putenv('KEY=dfgfgghhfgh');

        $result = $this->controllerWeather->getCityInfo(['./main.php', 'weather', 'new-yofdgdfgdfrk']);

        $this->assertEquals($result, '{"code":500, "message":"Error: invalid API key"}');

        putenv('KEY=' . getenv('KEY_BKP'));
    }

    /**
     * Test a request with wrong url.
     *
     * This method tests response with wrong url.
     */
    public function testWrongUrl(): void
    {
        putenv('API_URL=https://api.xxxxxxxxx.org/data/2.5/');

        $controllerWeather = new WeatherController();
        $result = $controllerWeather->getCityInfo(['./main.php', 'weather', 'new-yofdgdfgdfrk']);

        $this->assertEquals($result, '{"code":500, "message":"Error: Cannot connect to host"}');

        putenv('API_URL=' . getenv('API_BKP'));
    }
}
