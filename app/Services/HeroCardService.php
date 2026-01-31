<?php

namespace App\Services;

use App\Models\HeroCard;
use App\Resources\HeroStat;
use Illuminate\Http\Request;

class HeroCardService
{
    public const COOKIE_NAME = 'current_hero';

    public function createFromDraft(string $filepath, string $prompt): HeroCard
    {
        return HeroCard::create([
            'user_id' => auth()->id(),
            'image_path' => $filepath,
            'prompt' => $prompt,
            'points' => random_int(10, 20),
            'stats' => $this->getRandomStats(),
        ]);
    }

    private function getRandomStats(): array
    {
        $allStats = HeroStat::cases();
        $randomKeys = array_rand($allStats, 3);

        $stats = [];
        foreach ($randomKeys as $key) {
            $stats[$allStats[$key]->value] = 1;
        }

        return $stats;
    }

    public function getHeroCardByUuid(Request $request): HeroCard | null
    {
        $heroUuid = $request->cookie(self::COOKIE_NAME);

        if (!$heroUuid) {
            return null;
        }

        return HeroCard::where('uuid', $heroUuid)->first();
    }
}
