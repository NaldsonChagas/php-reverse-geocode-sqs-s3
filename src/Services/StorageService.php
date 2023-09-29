<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\StorageClient;

readonly class StorageService
{
    public function __construct(
        private StorageClient $storageClient,
    ) {}

    public function getFileContent($key): array {
        return $this->storageClient->getFileContent($key);
    }
}
