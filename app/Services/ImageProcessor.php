<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageProcessor
{
    public static string $heroesFolder = 'heroes';

    // public static string $cardsFolder = 'cards';

    public function saveBase64ToStorage(string $base64): string
    {
        $filename = self::$heroesFolder.DIRECTORY_SEPARATOR.Str::uuid().'.webp';
        $decodedData = base64_decode($base64);

        if ($decodedData === false) {
            throw new \Exception('Invalid base64 string');
        }

        $image = ImageManager::gd()
            ->read($decodedData)
            ->scale(576)
            ->toWebp(80);

        Storage::disk('public')->put($filename, (string) $image);

        return $filename;
    }
}
