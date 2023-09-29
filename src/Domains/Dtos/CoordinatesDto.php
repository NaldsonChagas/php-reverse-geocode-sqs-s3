<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class CoordinatesDto
{
    public string $id;
    public string $latitude;
    public string $longitude;

    public function __construct(string $id, string $latitude, string $longitude)
    {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}