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

    public function get(string $url): array
    {
        try {
            $response = $this->client->request('GET', $url);

            return [
                'body' => $response->getBody()->getContents(),
                'headers' => $response->getHeaders(),
                'statusCode' => $response->getStatusCode(),
            ];
        } catch (GuzzleException $e) {
            error_log($e->getMessage());
        }
        return [];
    }

    public function post(string $url, array $payload): array
    {
        try {
            $response = $this->client->request('POST', $url, ['json' => $payload]);

            return [
                'body' => $response->getBody()->getContents(),
                'headers' => $response->getHeaders(),
                'statusCode' => $response->getStatusCode(),
            ];
        } catch (GuzzleException $e) {
            error_log($e->getMessage());
        }
        return [];
    }
}
