<?php

namespace App\Packages\Stability\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class HttpService
{
    private Client $httpClient;

    public function __construct(string $baseUrl)
    {
        $this->httpClient = new Client(['base_uri' => $baseUrl]);
    }

    public function sendRequest(array $headers, array $payload = null): ResponseInterface
    {
        $body = [];
        foreach ($payload as $key => $value) {
            $body[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        return $this->httpClient->request('post', '', [
            'headers' => $headers,
            RequestOptions::MULTIPART => $body,
        ]);
    }
}
