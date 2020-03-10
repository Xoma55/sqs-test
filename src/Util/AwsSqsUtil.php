<?php

namespace App\Util;

use Aws\Result;
use Aws\Sdk;

class AwsSqsUtil implements AwsSqsUtilInterface
{
    private const QUEUE_PREFIX = 'XOMA55_';

    private $client;

    public function __construct(Sdk $sdk, iterable $config, iterable $credentials)
    {
        $this->client = $sdk->createSqs($config + $credentials);
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#createqueue
     */
    public function createQueue(string $name): ?string
    {
        /** @var Result $result */
        $result = $this->client->createQueue(['QueueName' => self::QUEUE_PREFIX . $name]);

        return $result->get('QueueUrl');
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#listqueues
     */
    public function listQueues(): iterable
    {
        $queues = [];

        /** @var Result $result */
        $result = $this->client->listQueues();
        foreach ($result->get('QueueUrls') as $queueUrl) {
            $queues[] = $queueUrl;
        }

        return $queues;
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#getqueueurl
     */
    public function getQueueUrl(string $name): ?string
    {
        /** @var Result $result */
        $result = $this->client->getQueueUrl(['QueueName' => self::QUEUE_PREFIX . $name]);

        return $result->get('QueueUrl');
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#sendmessage
     */
    public function sendMessage(string $url, string $message): ?string
    {
        /** @var Result $result */
        $result = $this->client->sendMessage([
            'QueueUrl' => $url,
            'MessageBody' => $message,
        ]);

        return $result->get('MessageId');
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#getqueueattributes
     */
    public function getTotalMessages(string $url): string
    {
        /** @var Result $result */
        $result = $this->client->getQueueAttributes([
            'QueueUrl' => $url,
            'AttributeNames' => ['ApproximateNumberOfMessages'],
        ]);

        return $result->get('Attributes')['ApproximateNumberOfMessages'];
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#purgequeue
     */
    public function purgeQueue(string $url): void
    {
        $this->client->purgeQueue(['QueueUrl' => $url]);
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#deletequeue
     */
    public function deleteQueue(string $url): void
    {
        $this->client->deleteQueue(['QueueUrl' => $url]);
    }

    /**
     * @link https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sqs-2012-11-05.html#receivemessage
     */
    public function receiveMessage(string $url): ?Message
    {
        /** @var Result $result */
        $result = $this->client->receiveMessage([
            'QueueUrl' => $url,
            'MaxNumberOfMessages' => 1,
        ]);

        $message = null;
        if (null !== $result->get('Messages')) {
            $message = new Message();
            $message->url = $url;
            $message->id = $result->get('Messages')[0]['MessageId'];
            $message->body = $result->get('Messages')[0]['Body'];
            $message->receiptHandle = $result->get('Messages')[0]['ReceiptHandle'];
        }

        return $message;
    }
}
