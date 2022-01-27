<?php
    declare(strict_types=1);

    namespace App\Services;

    require_once(getenv('SITE_ROOT')."/vendor/autoload.php");
    require_once(getenv('SITE_ROOT')."/Interfaces/HttpClientInterface.php");
    
    use App\Interfaces\HttpClientInterface;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\BadResponseException;
    use GuzzleHttp\Exception\ConnectException ;

/**
 * Class description
 *
 * @author Albert Ferraté
 * This class represents the implementation of the contract HttpClientInterface
 */
class GuzzleClient implements HttpClientInterface
{
    const MSG_ERROR_CITY = 'Error: city not found';
    const MSG_ERROR_HOST = 'Error: Cannot connect to host';
    const MSG_ERROR_API = 'Error: invalid API key';
    const MSG_ERROR_UNKNOWN = 'Error: unknown error';
    
    /**
     * Property http client
     *
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => getenv('API_URL')]);
    }

    /**
     * Get information of the city
     *
     * This method gets city and returns a response with data.
     * Depending of the exception returns a different message.
     * @param string $city this var contains the city formatted
     * @return string json with data weather
     */
    public function sendRequestWeather(string $city): string
    {
        try {
            $response = $this->client->request('GET', 'weather?q='.$city.'&appid='.getenv('KEY').'&units=metric')->getBody()->getContents();

            return $response;
        } catch (BadResponseException $e) {
            if (strpos($e->getMessage(), 'city not found') !== false) {
                return self::MSG_ERROR_CITY;
            }

            if (strpos($e->getMessage(), 'Invalid API key') !== false) {
                return self::MSG_ERROR_API;
            }

            return self::MSG_ERROR_UNKNOWN;
        } catch (ConnectException  $e) {
            if (strpos($e->getMessage(), 'Could not resolve host') !== false) {
                return self::MSG_ERROR_HOST;
            }

            return self::MSG_ERROR_UNKNOWN;
        } catch (Exception $e) {
            return self::MSG_ERROR_UNKNOWN;
        }
    }
}
