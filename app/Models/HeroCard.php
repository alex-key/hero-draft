<?php

namespace App\Models;

use App\Resources\HeroRarity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeroCard extends Model
{
    /** @use HasFactory<\Database\Factories\HeroCardFactory> */
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($heroCard) {
            $heroCard->uuid = (string) Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image_path',
        'points',
        'prompt',
        'stats',
    ];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
        ];
    }

    public function isFinished(): self
    {
        return $this->setAttribute('is_finished', true);
    }

    public function getRarity(): HeroRarity
    {
        if ($this->points > 14) {
            return $this->rarityMap()[$this->points];
        }

        return HeroRarity::Common;
    }

    public function finalize($data): self
    {
        $this->isFinished()->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'stats' => arsort($data['stats']),
        ]);

        return $this;
    }

    private function rarityMap(): array
    {
        return [
            15 => HeroRarity::Rare,
            16 => HeroRarity::Rare,
            17 => HeroRarity::Rare,
            18 => HeroRarity::Elite,
            19 => HeroRarity::Unique,
            20 => HeroRarity::Legendary,
        ];
    }
}
