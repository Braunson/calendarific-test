<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CalendarificService
{
    /**
     * The HTTP Facade to aid in calling the API
     *
     * @var Illuminate\Support\Facades\Http
     */
    protected $http;

    /**
     * The API Endpoint set in the config/env
     *
     * @var string
     */
    protected $apiEndpoint;

    /**
     * The API Key used to access the Calendarific API
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Headers provided to the API endpoint
     *
     * @var array
     */
    protected $headers = [
        'accept' => 'application/json'
    ];

    /**
     * The amount of time (in seconds) we want to cache the API data
     * Default is 24 hours or 86400 seconds
     *
     * @var string
     */
    protected $cacheTime = 86400;

    /**
     * The prepended cache key for caching data from the API
     *
     * @var string
     */
    protected $cacheKey = 'calendarific';

	public function __construct(Http $http)
	{
        $this->http         = $http;
        $this->apiKey       = config('services.calendarific.key');
        $this->apiEndpoint  = config('services.calendarific.endpoint');
    }

    /**
     * Make a call to the Calendarific API Endpoint with the given section and parameters
     *
     * @param string $section
     * @param array  $prameters
     * @return JSON
     */
    protected function call($section, $parameters = [])
    {
        $endpoint   = $this->apiEndpoint . '/' . $section;
        $parameters = array_merge(['api_key' => $this->apiKey], $parameters);

        $response = $this->http::withHeaders($this->headers)
            ->get(
                $endpoint,
                $parameters
            )->json();

        return $this->handleResponse(
            $response
        );
    }

    /**
     * Handle the response from Calendarific
     *
     *
     * @param Response $response
     * @return Response
     */
    public function handleResponse($response)
	{
        // @TODO Some error handeling based on the Calendarific API error codes..

        return $response;
	}

    /**
     * This provides a list of holidays based on the parameters passed to it.
     *
     * @param array $parameters
     * @return JSON
     */
    public function getHolidays($parameters)
    {
        $api = $this;

        // Generate our cache key
        $key = implode('_', array_merge([
            $this->cacheKey,
            'holidays',
        ], $parameters));

        // Grab holidays from the cache or make the call and cache the data
        return cache()->remember($key, $this->cacheTime, function() use ($api, $parameters) {
            return $api->call('holidays', $parameters)['response']['holidays'];
        });
    }

    /**
     * This endpoint provides a list of countries and languages that Calendarific support.
     * This is useful for getting an index of all countries and the ISO codes programmatically.
     *
     * @return JSON
     */
    public function getCountries()
    {
        $api = $this;

        // Grab countries from the cache or make the call and cache the data
        return cache()->remember($this->cacheKey . '_countries', $this->cacheTime, function() use ($api) {
            return $api->call('countries')['response']['countries'];
        });
    }

    /**
     * Grab the countries and format them for the Buefy select field
     *
     * @return Collection
     */
    public function getCountriesForSelect()
    {
        return collect($this->getCountries())
            ->map(function ($item, $key) {
                return [
                    'key'   => $key,
                    'label' => $item['country_name'],
                    'value' => $item['iso-3166'],
                ];
            });
    }

    /**
     * Grab the holidays and format the data for the Buefy table field
     *
     * @param array $parameters
     * @return Array
     */
    public function getHolidaysForTable($parameters)
    {
        // Grab only the data we want to display right now
        $data = collect($this->getHolidays($parameters))
            ->map(function ($item, $key) {
                return [
                    'name'        => $item['name'],
                    'description' => $item['description'],
                    'date'        => $item['date']['iso'],
                    'type'        => trim(implode(', ', $item['type']))
                ];
            })
            ->toArray();

        // Grab the column names from the first item (if any)
        $columns = count($data) ? head($data) : [];

        // Return the data
        return [
            'data'    => $data,
            'columns' => array_map(function($col) {
                return [
                    'field' => $col,
                    'label' => ucfirst($col),
                ];
            }, array_keys($columns))
    ];
    }
}
