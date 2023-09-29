<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\StorageClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Factories\CoordinatesDtoFactory;

class CoordinatesService
{
    public function getCoordinatesByMessages(array $messages, StorageClient $storageClient): array
    {
        $storageService = new StorageService($storageClient);
        return array_map(function($message) use ($storageService) {
            $fileContent = $storageService->getFileContent($message->key);
            return CoordinatesDtoFactory::byFileContent($fileContent);
        }, $messages);
    }
}