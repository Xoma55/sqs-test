<?php

namespace App\Util;

interface AwsSqsUtilInterface
{
    public function createQueue(string $name): ?string;

    public function listQueues(): iterable;

    public function getQueueUrl(string $name): ?string;

    public function sendMessage(string $url, string $message): ?string;

    public function getTotalMessages(string $url): string;

    public function purgeQueue(string $url): void;

    public function deleteQueue(string $url): void;
}
