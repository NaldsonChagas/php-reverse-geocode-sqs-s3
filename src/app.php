<?php

require 'vendor/autoload.php';

use ReverseGeocode\ReverseGeocodeMicroservice\Workers\ReverseGeocodeWorker;
use ReverseGeocode\ReverseGeocodeMicroservice\Configs\InitialConfigs;

(new InitialConfigs())->config();
(new ReverseGeocodeWorker())->init();
