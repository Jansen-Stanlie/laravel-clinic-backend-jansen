<?php

namespace App\Services;

use GuzzleHttp\Client;

class UnsplashService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.unsplash.com/',
            'headers' => [
                'Authorization' => 'Client-ID 393PObThIdRpwPTX54eSsDWx1KMMfBlK_VC5L9ML15s',
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function getRandomPersonPhoto()
    {
        $response = $this->client->request('GET', 'photos/random', [
            'query' => [
                'query' => 'people', // Change 'person' to 'people'
                'orientation' => 'portrait', // Ensure portrait orientation for person images
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['urls']['regular'] ?? null;
    }
}
