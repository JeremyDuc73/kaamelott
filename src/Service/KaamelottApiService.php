<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class KaamelottApiService
{
    public function __construct(private HttpClientInterface $httpClient){}

    public function getQuote(){
        $response = $this->httpClient->request(
            'GET',
            'https://kaamelott.chaudie.re/api/random'
        );

        return $response->toArray();
    }
}