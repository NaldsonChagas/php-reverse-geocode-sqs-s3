<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Factories;

use ReverseGeocode\ReverseGeocodeMicroservice\Configs\DotEnvConfig;

class ConfigsFactory
{

    public static function getConfigs(): array
    {
        $dotEnvConfig = new DotEnvConfig();

        return [
          $dotEnvConfig
        ];
    }
}