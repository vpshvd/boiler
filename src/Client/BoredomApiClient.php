<?php

namespace App\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class BoredomApiClient implements BoredomApiClientInterface
{
    public function __construct(protected  HttpClientInterface $client, protected string $apiUrl)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getActivity(int $participants): string
    {
        $url = $this->apiUrl . '/api/activity?participants='.$participants;
        $response =  $this->client->request('GET', $url);
        $status = $response->getStatusCode();
        if ($status != Response::HTTP_OK) {
            throw new \Exception('bed request'. $status);
        }
        return $response->getContent();

    }
}