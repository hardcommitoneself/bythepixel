<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use App\Exceptions\InvalidConfiguration;
use App\Exceptions\WeatherException;

class WeatherClient
{
    /**
     * Tomorrow API key : https://tomorrow.io/
     *
     * @var string
     */
    protected string $api_key;

    /**
     * Base endpoint : https://api.tomorrow.io/
     *
     * @var string
     */
    protected string $url = 'https://api.tomorrow.io/';

    /**
     * Units : available units are c, f
     *
     * For temperature in Fahrenheit (f) and wind speed in miles/hour, use units=imperial
     * For temperature in Celsius (c) and wind speed in meter/sec, use units=metric
     *
     * @var array
     */
    protected $units = [
        'c' => 'metric',
        'f' => 'imperial'
    ];

    /**
     * Client instance
     *
     * @var Client
     */
    protected $service;

    /**
     * Config
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        self::setConfigParameters();
        self::setApi();
    }

    /**
     * Set config parameters
     *
     * @return void
     */
    protected function setConfigParameters()
    {
        $this->config = config('tomorrow');
    }

    /**
     * Set Tommorw API key
     *
     * @return void
     */
    protected function setApi()
    {
        $this->api_key = $this->config['api_key'];

        if (!$this->api_key) {
            throw new InvalidConfiguration();
        }
    }

    /**
     * Build query parameters.
     *
     * @param array $params
     * @return string
     */
    private function buildQueryString(array $params)
    {
        $params['units'] = $this->units[$this->config['temp_format']];
        $params['apikey'] = $this->config['api_key'];

        return http_build_query($params);
    }

    /**
     * Init client instance
     */
    public function client()
    {
        $this->service = new Client([
            'base_uri' => $this->url
        ]);

        return $this;
    }

    /**
     * Fetch weather data
     *
     * @param string $route
     * @param array $params
     * @return mixed
     */
    public function fetch(string $route, array $params = [])
    {
        try {
            $route .= $this->buildQueryString($params);

            $response = $this->service->request('GET', $route);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody()->getContents());
            }
        } catch (ClientException | RequestException | ConnectException | ServerException | TooManyRedirectsException $e) {
            throw new WeatherException($e->getMessage());
        }
    }
}
