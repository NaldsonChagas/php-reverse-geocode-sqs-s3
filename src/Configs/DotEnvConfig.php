<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Configs;

use Dotenv\Dotenv;

class DotEnvConfig implements Config
{

    public function config(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
    }
}