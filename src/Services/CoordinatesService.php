<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\StorageClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinatesByEmailDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\ReverseGeocodeMessageDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Factories\CoordinatesByEmailDtoFactory;

class CoordinatesService
{
    public function getCoordinatesByEmail(
        ReverseGeocodeMessageDto $message,
        StorageClient $storageClient
    ): CoordinatesByEmailDto {
        $storageService = new StorageService($storageClient);
        $fileContent = $storageService->getFileContent($message->key);
        return CoordinatesByEmailDtoFactory::byFileContent($message->email, $fileContent);
    }
}
