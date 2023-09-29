<?php

require 'vendor/autoload.php';

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;

use ReverseGeocode\ReverseGeocodeMicroservice\Configs\InitialConfigs;

(new InitialConfigs())->config();

$sqsMessageConsumer = new SqsMessageConsumer();
$messages = (new ReverseGeocodeFileConsumer($sqsMessageConsumer))->getMessages();

var_dump($messages);
