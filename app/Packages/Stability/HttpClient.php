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
        $this->httpService = new HttpService(config('stability.base_url').$model->value);

        $this->setHeaders()->setParams();
    }

    private function setParams(): void
    {
        $this->params = [
            'prompt' => '',
            'aspect_ratio' => config('stability.image_aspect_ratio'),
            'output_format' => config('stability.image_output_format'),
            'style_preset' => 'cinematic', //TODO: test other presets
        ];
    }

    private function setHeaders(): self
    {
        $this->headers = [
            'authorization' => 'Bearer '.config('stability.api_key'),
            'accept' => 'application/json',
            'stability-client-id' => config('stability.client_id'),
        ];

        return $this;
    }

    private function setPrompt(string $prompt)
    {
        $this->params['prompt'] = $prompt.$this->getDefaultPromptAppend();
    }

    private function handle($jsonResponse): object
    {
        $result = ['success' => false];

        if (! is_null($jsonResponse)) {
            $response = json_decode($jsonResponse->getBody()->getContents(), true);

            $result['success'] = true;
            $result['data'] = $response;
        }

        return (object) $result;
    }

    public function textToImage(string $prompt): object
    {
        $this->setPrompt($prompt);

        $jsonResponse = null;
        try {
            $jsonResponse = $this->httpService->sendRequest($this->headers, $this->params);
        } catch (\Exception $e) {
            // todo check if any additional logging is needed
        }

        return $this->handle($jsonResponse);
    }

    private function getDefaultPromptAppend(): string
    {
        return ', hero shot, centered, 3/4 view or front-facing camera, medium shot framing from waist up, cinematic '.
            'lighting, stylized digital illustration, high-end animation style, intricate textures, clean lines, '.
            'professional character design, vibrant but sophisticated color palette, trending on ArtStation'.
            ' --no childish, low-effort, cartoonish, distorted proportions';
    }
}
