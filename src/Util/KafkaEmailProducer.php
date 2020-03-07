<?php

namespace App\Util;

use App\Messenger\Command\SendMailCommandInterface;
use Symfony\Component\Serializer\SerializerInterface;
use SymfonyBundles\KafkaBundle\DependencyInjection\Traits\ProducerTrait;

class KafkaEmailProducer implements KafkaEmailProducerInterface
{
    /** @var SerializerInterface  */
    private $serializer;

    use ProducerTrait;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     */
    public function send(SendMailCommandInterface $command): void
    {

        $data = json_decode($this->serializer->serialize($command, 'json'), true);

        $this->producer->send(KafkaEmailConsumer::QUEUE_NAME, $data);
    }
}
