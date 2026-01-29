<?php

namespace App\Packages\Stability;

use App\Packages\Stability\Resources\StabilityModel;
use App\Packages\Stability\Services\HttpService;

class HttpClient
{
    private HttpService $httpService;

    private array $params = [];

    private array $headers = [];

    public function __construct(StabilityModel $model = StabilityModel::CORE)
    {
        $this->httpService = new HttpService(config('stability.base_url') . $model->value);

        $this->setHeaders()->setParams();
    }


    private function setParams(): self
    {
        $this->params = [
            'prompt' => '',
            'aspect_ratio' => config('stability.image_aspect_ratio'),
            'output_format' => config('stability.image_output_format'),
        ];

        return $this;
    }

    private function setHeaders(): self {
        $this->headers = [
            'authorization' => 'Bearer ' . config('stability.api_key'),
            'accept' => 'application/json',
            'stability-client-id' => config('stability.client_id'),
        ];

        return $this;
    }

    private function handle($jsonResponse): object
    {
        $result = ['success' => false];

        if (!is_null($jsonResponse)) {
            $response = json_decode($jsonResponse->getBody()->getContents(), true);

            $result['success'] = true;
            $result['data'] = $response;
        }

        return (object)$result;
    }

    public function textToImage(string $prompt): object {
        $this->params['prompt'] = $prompt;

        $jsonResponse = null;
        try {
            $jsonResponse = $this->httpService->sendRequest($this->headers, $this->params);
        } catch (\Exception $e) {
            // todo check if any additional logging is needed
        }

        return $this->handle($jsonResponse);
    }


}
