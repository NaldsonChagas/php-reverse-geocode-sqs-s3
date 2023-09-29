<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

interface MessageConsumerClient
{
    public function getMessages(): array;
}