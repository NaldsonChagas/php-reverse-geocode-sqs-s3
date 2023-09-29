<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Consumers;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\MessageConsumerClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\ReverseGeocodeMessageDto;

readonly class ReverseGeocodeFileConsumer
{
    public function __construct(
        private MessageConsumerClient $messageReceiverClient
    ) {}

    public function getMessages(): array
    {
        return array_map(function ($message) {
            $messageAttributes = $message['MessageAttributes'];
            return new ReverseGeocodeMessageDto(
                $messageAttributes['Key']['StringValue'], $messageAttributes['SenderEmail']['StringValue']
            );
        }, $this->messageReceiverClient->getMessages());
    }
}
