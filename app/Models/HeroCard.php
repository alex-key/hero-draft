<?php

namespace App\Models;

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
}
