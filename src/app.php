<?php

require 'vendor/autoload.php';

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeFileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\CoordinatesService;
use ReverseGeocode\ReverseGeocodeMicroservice\Configs\InitialConfigs;

(new InitialConfigs())->config();

$reverseFileConsumer = new ReverseGeocodeFileConsumer(new SqsMessageConsumer());
$messages = (new ReverseGeocodeFileService())->getMessages($reverseFileConsumer);
$coordinatesDto = (new CoordinatesService())->getCoordinatesByMessages($messages, new ProjectS3Client());

var_dump($coordinatesDto);
