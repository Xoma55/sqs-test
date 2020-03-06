<?php

namespace App\Controller;

use App\Messenger\Command\SendMailCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RedisTestController extends AbstractController
{
    /**
     * @Route("/redis/send-email", methods="POST")
     */
    public function sendEmail(): Response
    {
        /** @var SendMailCommand $command */
        $command = new SendMailCommand('xmv54080@gmail.com', 'Тестовое сообщение!');

        try {
            $this->dispatchMessage($command);
            return new JsonResponse(null, Response::HTTP_OK);
        } catch (UnrecoverableMessageHandlingException $exception) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/redis/info", methods="GET")
     */
    public function info(Request $request): Response
    {
        echo phpinfo();
        die();
    }
}
