<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;

class ReverseGeocodeFileService
{
    public function getMessages(ReverseGeocodeFileConsumer $consumer): array
    {
        return $consumer->getMessages();
    }
}