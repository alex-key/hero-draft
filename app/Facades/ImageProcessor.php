<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string saveBase64ToStorage(string $base64)
 *
 * @see \App\Services\ImageProcessor
 */
class ImageProcessor extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\ImageProcessor::class;
    }
}
