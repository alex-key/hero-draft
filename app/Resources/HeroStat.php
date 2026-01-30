<?php

namespace App\Resources;

enum HeroStat: string
{
    case Strength = 'strength';
    case Agility = 'agility';
    case Awesomeness = 'awesomeness';
    case Dexterity = 'dexterity';
    case Accuracy = 'accuracy';
    case Humor = 'humor';
    case Vitality = 'vitality';
    case Stealth = 'stealth';
    case Charisma = 'charisma';
    case Luck = 'luck';
    case Bravado = 'bravado';
    case Haste = 'haste';
    case Healing = 'healing';
    case Perception = 'perception';
    case Tenacity = 'tenacity';
    case Resilience = 'resilience';
    case Spirituality = 'spirituality';
    case Intelligence = 'intelligence';
    case Aura = 'aura';
    case Focus = 'focus';
    case Greed = 'greed';
    case Sympathy = 'sympathy';
    case Trickery = 'trickery';
    case Chaos = 'chaos';
    case Stamina = 'stamina';
    case Wisdom = 'wisdom';

    // Helper to get a readable label
    public function label(): string
    {
        return ucwords($this->value);
    }
}
