<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Factories;

use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinatesDto;

class CoordinatesDtoFactory
{
    public static function byFileContent(array $fileContent): array
    {
        if (empty($fileContent)) return [];
        if (str_starts_with($fileContent[0], 'id')) array_shift($fileContent);

        return array_map(function ($line) {
            $lineContent = explode(',', $line);
            $latitude = $lineContent[1];
            $longitude = $lineContent[2];
            return new CoordinatesDto($latitude, $longitude);
        }, $fileContent);
    }
}