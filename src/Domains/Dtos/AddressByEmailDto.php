<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class AddressByEmailDto
{
    public string $email;
    public array $address;

    public function __construct(string $email, array $address)
    {
        $this->email = $email;
        $this->address = $address;
    }
}