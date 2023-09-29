<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Configs;

use Dotenv\Dotenv;

class InitialConfigs
{
    public function config(): void
    {
        $this->configDotEnv();
    }

    private function configDotEnv(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
    }
}
