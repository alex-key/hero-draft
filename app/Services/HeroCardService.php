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
            'points' => $this->getRandomPoints(),
            'stats' => $this->getRandomStats(),
        ]);
    }

    public function getHeroCardByUuid(Request $request): ?HeroCard
    {
        $heroUuid = $request->cookie(self::COOKIE_NAME);

        if (! $heroUuid) {
            return null;
        }

        return HeroCard::where('uuid', $heroUuid)->first();
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

    private function getRandomPoints(): int
    {
        $roll = random_int(1, 100);

        return match (true) {
            $roll <= 60 => random_int(10, 14), // 60% Common
            $roll <= 90 => random_int(15, 17), // 30% Rare
            $roll <= 96 => 18, // 6% Elite
            $roll <= 99 => 19, // 3% Unique
            default => 20, // 1% Legendary
        };
    }
}
