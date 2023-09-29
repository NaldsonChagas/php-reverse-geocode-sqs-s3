<?php

require 'vendor/autoload.php';

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\StorageService;
use ReverseGeocode\ReverseGeocodeMicroservice\Factories\CoordinatesDtoFactory;
use ReverseGeocode\ReverseGeocodeMicroservice\Configs\InitialConfigs;

(new InitialConfigs())->config();

$sqsMessageConsumer = new SqsMessageConsumer();
$messages = (new ReverseGeocodeFileConsumer($sqsMessageConsumer))->getMessages();

$coordinatesDto = array_map(function($message) {
    $storageService = new StorageService(new ProjectS3Client());
    $fileContent = $storageService->getFileContent($message->key);
    return CoordinatesDtoFactory::getCoordinatesDtoByFileContent($fileContent);
}, $messages);

var_dump($coordinatesDto);
