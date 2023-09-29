<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;

class SqsMessageConsumer implements MessageConsumerClient
{
    private readonly SqsClient $sqsClient;

    public function __construct()
    {
        $this->sqsClient = new SqsClient([
            'region' => $_ENV['SQS_CLIENT_REGION'],
            'version' => $_ENV['SQS_CLIENT_VERSION'],
            'credentials' => [
                'key' => $_ENV['REVERSE_GEOCODE_AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['REVERSE_GEOCODE_AWS_SECRET_ACCESS_KEY']
            ]
        ]);
    }

    public function getMessages(): array
    {
        try {
            $result = $this->sqsClient->receiveMessage(array(
                'AttributeNames' => ['SentTimestamp'],
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $_ENV['SQS_GEOCODE_AVAILABLE_FILES_URL'],
                'WaitTimeSeconds' => 0,
            ));

            if (empty($result->get('Messages'))) {
                return [];
            }

            return $result->get('Messages');
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
