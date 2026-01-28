<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function generateHero(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:400'],
        ]);

        return response()->json([
            'prompt' => $validated['prompt'],
        ]);
    }

    public function loadCards(): JsonResponse
    {
      // todo add logic

      return response()->json([]);
    }
}
