<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class CoordinatesByEmailDto
{
    public string $email;
    public array $coordinates;

    public function __construct(string $email, array $coordinates)
    {
        $this->email = $email;
        $this->coordinates = $coordinates;
    }
}
