<?php

namespace App\Controller;

use App\Messenger\Command\SendMailCommand;
use App\Messenger\Command\SendMailCommandInterface;
use App\Util\KafkaEmailProducerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class KafkaTestController
{

    /**
     * @Route("/kafka/send-email", methods="POST")
     */
    public function sendEmail(KafkaEmailProducerInterface $producer)
    {
        /** @var SendMailCommandInterface $command */
        $command = new SendMailCommand('xmv54080@gmail.com', 'Ahhh!');

        $producer->send($command);

        return new JsonResponse([]);
    }

}
