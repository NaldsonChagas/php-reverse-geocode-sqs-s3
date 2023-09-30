<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos;

readonly class AddressByEmailDto
{
    public string $email;
    public array $addresses;

    public function __construct(string $email, array $addresses)
    {
        $this->email = $email;
        $this->addresses = $addresses;
    }
}