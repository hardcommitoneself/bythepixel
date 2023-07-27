<?php

namespace App;

/**
 * Laravel Tomorrow Weather API
 *
 * @author hardcommitoneself <hardcommitoneself@gmail.com>
 * @since 1.0.0
 */

class Weather
{
    /**
     * Get current weather of any location over the world.
     *
     * Documentation : https://docs.tomorrow.io/reference/realtime-weather
     *
     * @param array $query
     * @return mixed
     */
    public static function getCurrent(array $query)
    {
        $ep = '/v4/weather/realtime?';

        $data = (new WeatherClient())->client()->fetch($ep, $query);

        return $data;
    }

    /**
     * Get forecast weather of any location over the world.
     *
     * Documentation : https://docs.tomorrow.io/reference/weather-forecast
     *
     * @param array $query
     * @return mixed
     */
    public static function getForecast(array $query)
    {
        $ep = '/v4/weather/forecast?';

        $data = (new WeatherClient())->client()->fetch($ep, $query);

        return $data;
    }
}
