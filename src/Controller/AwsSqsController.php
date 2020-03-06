<?php

namespace App\Controller;

use App\Util\AwsSqsUtilInterface;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/aws")
 */
class AwsSqsController
{
    private $awsSqsUtil;

    public function __construct(AwsSqsUtilInterface $awsSqsUtil)
    {
        $this->awsSqsUtil = $awsSqsUtil;
    }

    /**
     * @Route("/sqs/create-queue", methods="POST")
     */
    public function createQueue(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        return new JsonResponse($this->awsSqsUtil->createQueue($content['name']));
    }

    /**
     * @Route("/sqs/list-queues", methods="GET")
     */
    public function listQueues(): Response
    {
        return new JsonResponse($this->awsSqsUtil->listQueues());
    }

    /**
     * @Route("/sqs/get-queue-url", methods="POST")
     */
    public function getQueueUrl(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        return new JsonResponse($this->awsSqsUtil->getQueueUrl($content['name']));
    }

    /**
     * @Route("/sqs/send-message", methods="POST")
     */
    public function sendMessage(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        return new JsonResponse($this->awsSqsUtil->sendMessage($content['url'], json_encode($content['message'])));
    }

    /**
     * @Route("/sqs/get-total-messages", methods="POST")
     */
    public function getTotalMessages(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        return new JsonResponse($this->awsSqsUtil->getTotalMessages($content['url']));
    }

    /**
     * @Route("/sqs/purge-queue", methods="DELETE")
     */
    public function purgeQueue(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $this->awsSqsUtil->purgeQueue($content['url']);

        return new JsonResponse('Purged!');
    }

    /**
     * @Route("/sqs/delete-queue", methods="DELETE")
     */
    public function deleteQueue(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $this->awsSqsUtil->deleteQueue($content['url']);

        return new JsonResponse('Deleted!');
    }
}
