<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

interface StorageClient {
    public function getFileContent($key): array;
}