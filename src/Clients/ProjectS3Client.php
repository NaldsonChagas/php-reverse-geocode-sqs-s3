<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

use Aws\S3\S3Client;

readonly class ProjectS3Client implements StorageClient
{
    private S3Client $s3Client;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'region' => $_ENV['S3_CLIENT_REGION'],
            'version' => $_ENV['S3_CLIENT_VERSION'],
            'credentials' => [
                'key' => $_ENV['REVERSE_GEOCODE_AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['REVERSE_GEOCODE_AWS_SECRET_ACCESS_KEY']
            ]
        ]);
    }

    public function getFileContent($key): array
    {
        try {
            $file = $this->s3Client->getObject([
                'Bucket' => $_ENV['S3_CLIENT_BUCKET'],
                'Key' => $key,
            ]);
            $body = $file->get('Body');
            return str_getcsv($body->getContents(), "\n");
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return [];
        }
    }
}