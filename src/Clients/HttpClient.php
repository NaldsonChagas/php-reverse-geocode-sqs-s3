<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

readonly class HttpClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url): array
    {
        $response = $this->client->request('GET', $url);

        return [
            'body' => $response->getBody()->getContents(),
            'headers' => $response->getHeaders(),
            'statusCode' => $response->getStatusCode(),
        ];
    }
}
