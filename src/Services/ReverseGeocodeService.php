<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ReverseGeocodeClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\AddressByEmailDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\AddressDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinatesByEmailDto;

readonly class ReverseGeocodeService
{
    public function __construct(private ReverseGeocodeClient $reverseGeocodeClient)
    {}

    public function getAddresses(CoordinatesByEmailDto $coordinatesByEmailDto): AddressByEmailDto
    {
        $addresses = array_map(function ($coordinate) {
            $address = $this->reverseGeocodeClient->getAddress($coordinate->latitude, $coordinate->longitude);
            return new AddressDto($coordinate->id, $address);
        }, $coordinatesByEmailDto->coordinates);

        return new AddressByEmailDto($coordinatesByEmailDto->email, $addresses);
    }
}
