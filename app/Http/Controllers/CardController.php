<?php

namespace App\Http\Controllers;

use App\Facades\ImageProcessor;
use App\Packages\Stability\HttpClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct(
        private HttpClient $stability
    ) {}

    public function generateHero(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:400'],
        ]);

        $result = $this->stability->textToImage($validated['prompt']);

        if ($result->success) {
            $filepath = ImageProcessor::saveBase64ToStorage($result->data['image']);

            return response()->json([
                'success' => $filepath,
            ]);
        }

        // TODO: improve, add proper error response
        return response()->json([
            'error' => 'Generation Failed',
        ]);
    }

    public function loadCards(): JsonResponse
    {
      // todo add logic

      return response()->json([]);
    }
}
