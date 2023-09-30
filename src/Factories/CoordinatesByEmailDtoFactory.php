<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Factories;

use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinatesByEmailDto;
use ReverseGeocode\ReverseGeocodeMicroservice\Domains\Dtos\CoordinateDto;

class CoordinatesByEmailDtoFactory
{
    public static function byFileContent(string $email, array $fileContent): CoordinatesByEmailDto
    {
        if (empty($fileContent)) return new CoordinatesByEmailDto($email, []);
        if (str_starts_with($fileContent[0], 'id')) array_shift($fileContent);

        $coordinatesDto = array_map(function ($line) {
            $lineContent = explode(',', $line);
            $id = $lineContent[0];
            $latitude = $lineContent[1];
            $longitude = $lineContent[2];
            return new CoordinateDto($id, $latitude, $longitude);
        }, $fileContent);

        return new CoordinatesByEmailDto($email, $coordinatesDto);
    }
}