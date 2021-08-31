<?php

namespace App\JwPlayer\API;

use Exception;
use GuzzleHttp\Client;

class API
{
    protected Client $client;

    public function __construct()
    {
        if (!config('jwplayer.api_key')) {
            throw new Exception('API Key not specified on the Package Configuration');
        }

        $this->client = new Client([
            'base_uri' => 'https://api.jwplayer.com/v2/',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => config('jwplayer.api_key'),
            ],
        ]);
    }

    public function client(): Client
    {
        return $this->client;
    }
}
