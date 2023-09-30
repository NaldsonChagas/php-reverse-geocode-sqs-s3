<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Logger;

readonly class Logger
{
    public static function log($message): void
    {
        echo "[" . date('Y-m-d H:i:s') . "] - " . $message . PHP_EOL;
    }
}