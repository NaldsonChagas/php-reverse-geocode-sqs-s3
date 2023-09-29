<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class ReverseGeocodeMessageDto
{
    public readonly string $key;
    public readonly string $email;

    public function __construct(string $key, string $email)
    {
        $this->key = $key;
        $this->email = $email;
    }
}
