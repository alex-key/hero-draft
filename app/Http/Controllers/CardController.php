<?php

namespace App\Http\Controllers;

use App\Facades\ImageProcessor;
use App\Packages\Stability\HttpClient;
use App\Resources\HeroStat;
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

    public function generateHero(Request $request, HeroCardService $heroCardService): JsonResponse | RedirectResponse
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:400'],
        ]);

        $result = $this->stability->textToImage($validated['prompt']);

        if ($result->success) {
            $filepath = ImageProcessor::saveBase64ToStorage($result->data['image']);
            $heroCard = $heroCardService->createFromDraft($filepath, $validated['prompt']);

            $cookie = cookie(HeroCardService::COOKIE_NAME, $heroCard->uuid);

            return redirect()->route('finish-hero')->withCookie($cookie);
        }

        // TODO: improve, add proper error response
        return response()->json([
            'error' => 'Generation Failed',
        ]);
    }

    public function finishHero(HeroCardService $heroCardService, Request $request): Response|RedirectResponse
    {
        $heroCard = $heroCardService->getHeroCardByUuid($request);

        if (! $heroCard) {
            return $this->home();
        }

        return Inertia::render('FinishHero', [
            'heroCard' => $heroCard,
        ]);
    }

    public function saveHero(HeroCardService $heroCardService, Request $request): RedirectResponse
    {
        $heroCard = $heroCardService->getHeroCardByUuid($request);

        if (! $heroCard) {
            return $this->home();
        }

        $validSkillNames = array_column(HeroStat::cases(), 'value');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'stats' => ['required', 'array'],
            'stats.*' => ['required', 'integer', 'min:1'],
        ]);

        // Validate skill names match HeroStat enum
        foreach (array_keys($validated['stats']) as $skillName) {
            if (!in_array($skillName, $validSkillNames)) {
                return back()->withErrors(['stats' => "Invalid skill name: {$skillName}"]);
            }
        }

        // Validate total points match
        $totalPoints = array_sum($validated['stats']);
        if ($totalPoints !== $heroCard->points) {
            return back()->withErrors(['stats' => "Total skill points must equal {$heroCard->points}"]);
        }

        $heroCard->finalize([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stats' => $validated['stats'],
        ]);

        return redirect()->route('home')->withCookie(cookie()->forget(HeroCardService::COOKIE_NAME));
    }
}
