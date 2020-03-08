<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClientTestController extends AbstractController
{
    /**
     * @param HttpClientInterface $httpClient
     * @return Response
     * @throws TransportExceptionInterface
     * @Route("/currency/as-json", methods="GET")
     */
    public function testOne(HttpClientInterface $httpClient)
    {
        /** @var string $url */
        $url = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';

        try {
            /** @var ResponseInterface $response */
            $response = $httpClient->request('GET', $url);
            $data = json_decode($response->getContent());

            return $this->render('currency.html.twig', ['data' => $data]);

        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $exception) {
            return new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param HttpClientInterface $httpClient
     * @return Response
     * @throws TransportExceptionInterface
     * @throws \Exception
     * @Route("/debian/save", methods="GET")
     */
    public function testTwo(HttpClientInterface $httpClient)
    {
        $url = 'http://deb.debian.org/debian/dists/buster/main/installer-amd64/current/images/netboot/mini.iso';

        $response = $httpClient->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new \Exception('Bad request');
        }

        $fileHandler = fopen('mini.iso', 'w');
        foreach ($httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        return new Response('Save completed', Response::HTTP_OK);
    }
}
