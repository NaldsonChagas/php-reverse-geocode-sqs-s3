<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Consumers;

use ReverseGeocode\ReverseGeocodeMicroservice\Clients\MessageConsumerClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Factories\ReverseGeocodeMessageDtoFactory;

readonly class ReverseGeocodeFileConsumer
{
    public function __construct(
        private MessageConsumerClient $messageReceiverClient
    ) {}

    public function getMessages(): array
    {
        return ReverseGeocodeMessageDtoFactory::byConsumerMessages($this->messageReceiverClient->getMessages());
    }
}
