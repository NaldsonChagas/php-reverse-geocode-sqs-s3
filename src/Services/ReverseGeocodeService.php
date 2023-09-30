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

    public function addressesToCSVFormat(AddressByEmailDto $addressByEmailDto): array
    {
        $header = ['id', 'address'];

        $data = [$header];

        foreach ($addressByEmailDto->addresses as $address) {
            $data[] = [$address->id, $address->address];
        }

        return $data;
    }
}
