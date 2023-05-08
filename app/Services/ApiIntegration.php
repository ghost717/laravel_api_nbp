<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiIntegration
{
    CONST apiUrl = "http://api.nbp.pl/api/exchangerates/tables/A/";

    private string $apiUrl = '';
    private object $client;
    private object $response;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function makeApiCall(): array
    {
        $this->setApiUrl(self::apiUrl);
        $this->response = $this->client->get($this->apiUrl);
        return json_decode($this->response->getBody(), true);
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     * 
     * @return string
     */
    public function setApiUrl(string $apiUrl): string
    {
        return $this->apiUrl = $apiUrl;
    }

    /**
     * @return object
     */
    public function getClient(): object
    {
        return $this->client;
    }

    /**
     * @param Object $client
     * 
     * @return object
     */
    public function setClient(Object $client): object
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return object
     */
    public function getResponse(): object
    {
        return $this->response;
    }

    /**
     * @param Object $response
     * 
     * @return object
     */
    public function setResponse(Object $response): object
    {
        return $this->response = $response;
    }
}
