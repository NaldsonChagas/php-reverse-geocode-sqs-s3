<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Configs;

use ReverseGeocode\ReverseGeocodeMicroservice\Factories\ConfigsFactory;

readonly class InitialConfigs
{
    private array $configs;

    public function __construct()
    {
        $this->configs = ConfigsFactory::getConfigs();
    }

    public function config(): void
    {
        foreach ($this->configs as $config) {
            $config->config();
        }
    }
}
