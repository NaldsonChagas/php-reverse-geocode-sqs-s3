<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Services;

class FileService
{
    public function toCSV(array $addressesData): false|string
    {
        $tempFile = fopen('php://temp', 'w');
        foreach ($addressesData as $line) {
            fputcsv($tempFile, $line);
        }
        rewind($tempFile);

        $csv = stream_get_contents($tempFile);

        fclose($tempFile);

        return $csv;
    }
}