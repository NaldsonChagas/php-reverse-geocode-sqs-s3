<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class CoordinatesDto
{
    public readonly string $latitude;
    public readonly string $longitute;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitute = $longitude;
    }
}