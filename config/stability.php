<?php

return [
    'api_key' => env('STABILITY_API_KEY'),

    // for purposes of this application we use only v2beta Generate API
    // see: https://platform.stability.ai/docs/api-reference#tag/Generate
    'base_url' => 'https://api.stability.ai/v2beta/stable-image/generate/',

    'client_id' => 'hero-draft',

    // defaulted to portrait orientation image
    'image_aspect_ratio' => '9:16',

    'image_output_format' => 'webp',
];
