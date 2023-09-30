<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\HttpClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ReverseGeocodeClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\AddressByEmailDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\AddressDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinatesByEmailDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Logger\Logger;

readonly class ReverseGeocodeService
{
    private HttpClient $httpClient;
    
    public function __construct(
        private ReverseGeocodeClient $reverseGeocodeClient,
    ) {
        $this->httpClient = new HttpClient();
    }

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

    public function sendAddresses(string $destination, string $addressesAttachment): void {
        Logger::log("Sending email to $destination");
        $emailPayload = [
            'destinationEmail' => $destination,
            'attachment' => base64_encode($addressesAttachment)
        ];
        $this->httpClient->post($_ENV['SEND_EMAIL_URL'], $emailPayload);
        Logger::log('Email sended');
    }
}
