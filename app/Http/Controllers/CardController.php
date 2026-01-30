<?php

namespace App\Http\Controllers;

use App\Facades\ImageProcessor;
use App\Models\HeroCard;
use App\Packages\Stability\HttpClient;
use App\Services\HeroCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CardController extends Controller
{
    public function __construct(
        private HttpClient $stability
    ) {}

    public function loadCards(): JsonResponse
    {
        // todo add logic

        return response()->json([]);
    }

    public function generateHero(Request $request, HeroCardService $heroCardService): JsonResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:400'],
        ]);

        $result = $this->stability->textToImage($validated['prompt']);

        if ($result->success) {
            $filepath = ImageProcessor::saveBase64ToStorage($result->data['image']);
            $heroCard = $heroCardService->createFromDraft($filepath, $validated['prompt']);

            $cookie = cookie('current_hero', $heroCard->uuid);

            return response()->json([
                'success' => $filepath,
            ])->withCookie($cookie);
        }

        // TODO: improve, add proper error response
        return response()->json([
            'error' => 'Generation Failed',
        ]);
    }

    public function finishHero(Request $request): Response|RedirectResponse
    {
        $heroUuid = $request->cookie('current_hero');

        if (!$heroUuid) {
            return redirect()->route('home');
        }

        $heroCard = HeroCard::where('uuid', $heroUuid)->first();

        if (!$heroCard) {
            return redirect()->route('home');
        }

        return Inertia::render('FinishHero', [
            'heroCard' => $heroCard,
        ]);
    }
}
