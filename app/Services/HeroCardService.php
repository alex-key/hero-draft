<?php

namespace App\Services;

use App\Models\HeroCard;
use App\Resources\HeroStat;

class HeroCardService
{
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
}
