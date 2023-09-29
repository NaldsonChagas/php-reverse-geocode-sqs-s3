<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Factories;

use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\ReverseGeocodeMessageDto;

class ReverseGeocodeMessageDtoFactory
{
    public static function byConsumerMessages(array $messages): array
    {
        return array_map(function ($message) {
            $messageAttributes = $message['MessageAttributes'];
            return new ReverseGeocodeMessageDto(
                $messageAttributes['Key']['StringValue'], $messageAttributes['SenderEmail']['StringValue']
            );
        }, $messages);
    }
}
