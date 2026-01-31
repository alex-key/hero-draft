<?php

namespace App\Resources;

enum HeroRarity: string
{
    case Common = 'common';
    case Rare = 'rare';
    case Elite = 'elite';
    case Unique = 'unique';
    case Legendary = 'legendary';

    // Helper to get a readable label
    public function label(): string
    {
        return ucwords($this->value);
    }
}
