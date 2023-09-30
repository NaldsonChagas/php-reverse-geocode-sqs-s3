<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Workers;

use ReverseGeocode\ReverseGeocodeMicroservice\Consumers\ReverseGeocodeFileConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\SqsMessageConsumer;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\ProjectS3Client;
use ReverseGeocode\ReverseGeocodeMicroservice\Clients\GoogleReverseGeocodeClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Logger\Logger;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\FileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeFileService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\CoordinatesService;
use ReverseGeocode\ReverseGeocodeMicroservice\Services\ReverseGeocodeService;

class ReverseGeocodeWorker
{
    private function applicationInit(): void
    {
        $reverseFileConsumer = new ReverseGeocodeFileConsumer(new SqsMessageConsumer());
        $messages = (new ReverseGeocodeFileService())->getMessages($reverseFileConsumer);

        $reverseGeocodeService = new ReverseGeocodeService(new GoogleReverseGeocodeClient());

        foreach ($messages as $message) {
            $coordinatesByEmailDto = (new CoordinatesService())->getCoordinatesByEmail($message, new ProjectS3Client());
            $addressesByEmailDto = $reverseGeocodeService->getAddresses($coordinatesByEmailDto);
            $addressToCsvFormat = $reverseGeocodeService->addressesToCSVFormat($addressesByEmailDto);
            $addressCsvFormat = (new FileService())->toCSV($addressToCsvFormat);
            $reverseGeocodeService->sendAddresses($coordinatesByEmailDto->email, $addressCsvFormat);
        }
    }

    public function init(): void
    {
        Logger::log('Initializing process... Listening for new messages');
        while (true) {
            $this->applicationInit();
            sleep(10);
        }
    }
}
