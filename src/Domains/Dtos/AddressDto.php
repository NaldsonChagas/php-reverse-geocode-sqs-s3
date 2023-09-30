<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class AddressDto
{
    public string $id;
    public string $address;

    public function __construct(string $id, string $address)
    {
        $this->id = $id;
        $this->address = $address;
    }
}