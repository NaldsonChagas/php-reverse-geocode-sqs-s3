<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

interface ReverseGeocodeClient
{
    function getAddress(string $latitude, string $longitude);
}