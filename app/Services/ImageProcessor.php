<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageProcessor
{
    public static string $heroesFolder = 'heroes';

    //public static string $cardsFolder = 'cards';

    public function saveBase64ToStorage(string $base64): string
    {
        $filename = Str::uuid() . '.webp';

        $image = ImageManager::gd()
            ->read(base64_decode($base64))
            ->toWebp(80);

        Storage::disk('public')->put(self::$heroesFolder.DIRECTORY_SEPARATOR.$filename, (string) $image);

        return $filename;
    }
}
