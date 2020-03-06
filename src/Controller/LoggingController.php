<?php

namespace App\Controller;

use App\Messenger\Command\SaveToFileCommand;
use App\Messenger\Command\SaveToFileCommandInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Routing\Annotation\Route;

class LoggingController extends AbstractController
{
    /**
     * @Route("/logging/log", methods="GET")
     */
    public function log(Request $request): Response
    {
        /** @var SaveToFileCommandInterface $command */
        $command = new SaveToFileCommand(rand(11111, 22222) . '.txt', 'Тестовое сообщение!');

        try {
            $result = $this->dispatchMessage($command);
            return new JsonResponse(['result' => $result], Response::HTTP_OK);
        } catch (UnrecoverableMessageHandlingException $exception) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
    }

}
