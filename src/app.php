<?php

require 'vendor/autoload.php';

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use \ReverseGeocode\ReverseGeocodeMicroservice\Clients\GoogleReverseGeocodeClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeFileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\CoordinatesService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeService;
use ReverseGeocode\ReverseGeocodeMicroservice\Configs\InitialConfigs;

(new InitialConfigs())->config();

$reverseFileConsumer = new ReverseGeocodeFileConsumer(new SqsMessageConsumer());
$messages = (new ReverseGeocodeFileService())->getMessages($reverseFileConsumer);

foreach ($messages as $message) {
    $coordinatesByEmailDto = (new CoordinatesService())->getCoordinatesByEmail($message, new ProjectS3Client());
    $addressesByEmailDto = (new ReverseGeocodeService(new GoogleReverseGeocodeClient()))
        ->getAddresses($coordinatesByEmailDto);
}
