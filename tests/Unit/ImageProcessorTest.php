<?php

namespace Tests\Unit;

use App\Services\ImageProcessor;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageProcessorTest extends TestCase
{
    // Minimal 1×1 white pixel PNG, valid for GD
    private const BASE64_PNG = 'UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAARBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD+/gbQAA==';

    private ImageProcessor $processor;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->processor = new ImageProcessor;
    }

    public function test_heroes_folder_is_heroes(): void
    {
        $this->assertEquals('heroes', ImageProcessor::$heroesFolder);
    }

    public function test_save_base64_returns_path_inside_heroes_folder(): void
    {
        $path = $this->processor->saveBase64ToStorage(self::BASE64_PNG);

        $this->assertStringStartsWith('heroes'.DIRECTORY_SEPARATOR, $path);
    }

    public function test_save_base64_returns_webp_path(): void
    {
        $path = $this->processor->saveBase64ToStorage(self::BASE64_PNG);

        $this->assertStringEndsWith('.webp', $path);
    }

    public function test_save_base64_persists_file_to_public_disk(): void
    {
        $path = $this->processor->saveBase64ToStorage(self::BASE64_PNG);

        Storage::disk('public')->assertExists($path);
    }

    public function test_save_base64_generates_unique_filenames(): void
    {
        $first = $this->processor->saveBase64ToStorage(self::BASE64_PNG);
        $second = $this->processor->saveBase64ToStorage(self::BASE64_PNG);

        $this->assertNotEquals($first, $second);
    }

    public function test_save_base64_filename_contains_valid_uuid(): void
    {
        $path = $this->processor->saveBase64ToStorage(self::BASE64_PNG);

        $filename = pathinfo($path, PATHINFO_FILENAME);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $filename
        );
    }
}
