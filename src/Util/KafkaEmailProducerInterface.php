<?php

namespace App\Util;

use App\Messenger\Command\SendMailCommandInterface;

interface KafkaEmailProducerInterface
{
    public function send(SendMailCommandInterface $command): void;
}
