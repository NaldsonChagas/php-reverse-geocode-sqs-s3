<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class ReverseGeocodeMessageDto
{
    public string $key;
    public string $email;

    public function __construct(string $key, string $email)
    {
        $this->key = $key;
        $this->email = $email;
    }
}
