<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

readonly class GoogleReverseGeocodeClient implements ReverseGeocodeClient
{

    private HttpClient $client;

    private string $googleMapsKey;

    public function __construct() {
        $this->client = new HttpClient();
        $this->googleMapsKey = $_ENV['GOOGLE_MAPS_KEY'];
    }

    function getAddress(string $latitude, string $longitude)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$this->googleMapsKey";
        $response = $this->client->get($url);
        $body = json_decode($response['body'], true);

        return $body['results'][0]['formatted_address'];
    }
}