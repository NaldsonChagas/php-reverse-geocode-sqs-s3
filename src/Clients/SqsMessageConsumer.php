<?php

namespace ReverseGeocode\ReverseGeocodeMicroservice\Clients;

use Aws\Exception\AwsException;
use Aws\Result;
use Aws\Sqs\SqsClient;
use ReverseGeocode\ReverseGeocodeMicroservice\Logger\Logger;

readonly class SqsMessageConsumer implements MessageConsumerClient
{
    private SqsClient $sqsClient;

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
                'MaxNumberOfMessages' => 10,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $_ENV['SQS_GEOCODE_AVAILABLE_FILES_URL'],
                'WaitTimeSeconds' => 0,
            ));

            if (empty($result->get('Messages'))) {
                Logger::log('0 message found');
                return [];
            }

            Logger::log('New message');
            $messages = $result->get('Messages');

            $this->removeReceivedMessagesFromQueue($result);

            return $messages;
        } catch (AwsException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function removeReceivedMessagesFromQueue(Result $result): void
    {
        Logger::log('Removing received messages from queue');
        $messages = $result->get('Messages');
        foreach ($messages as $message) {
            $this->sqsClient->deleteMessage([
                'QueueUrl' => $_ENV['SQS_GEOCODE_AVAILABLE_FILES_URL'],
                'ReceiptHandle' => $message['ReceiptHandle']
            ]);
        }
        Logger::log('Removed received messages from queue');
    }
}
