<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Workers;

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\GoogleReverseGeocodeClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\FileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeFileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\CoordinatesService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeService;

class ReverseGeocodeWorker
{
    public function init(): void
    {
        $reverseFileConsumer = new ReverseGeocodeFileConsumer(new SqsMessageConsumer());
        $messages = (new ReverseGeocodeFileService())->getMessages($reverseFileConsumer);

        $reverseGeocodeService = new ReverseGeocodeService(new GoogleReverseGeocodeClient());

        foreach ($messages as $message) {
            $coordinatesByEmailDto = (new CoordinatesService())->getCoordinatesByEmail($message, new ProjectS3Client());
            $addressesByEmailDto = $reverseGeocodeService->getAddresses($coordinatesByEmailDto);
            (new FileService())->toCSV($reverseGeocodeService->addressesToCSVFormat($addressesByEmailDto));
        }
    }
}
