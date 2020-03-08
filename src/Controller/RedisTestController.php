<?php

namespace App\Controller;

use App\Data\ProductInterface;
use App\Messenger\Command\SendMailCommand;
use App\Util\RedisTestInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param RedisTestInterface $redisTest
     * @return JsonResponse
     * @Route("/redis/cache", methods="GET")
     */
    public function cache(RedisTestInterface $redisTest)
    {
        /** @var ProductInterface $product */
        $product = $redisTest->test('03420133-ee27-48ca-8c80-8360d03c8c0b');

        return new JsonResponse((array)$product);
    }
}
