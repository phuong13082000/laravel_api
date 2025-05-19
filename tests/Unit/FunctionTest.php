<?php

namespace Tests\Unit;

use App\Services\ImageUploadService;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FunctionTest extends TestCase
{
    public function test_delete_image_successfully()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');
        $file->storeAs('', 'test.jpg', 'public');

        $service = new ImageUploadService();

        $result = $service->deleteImage('category/test.jpg');

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing('test.jpg');
    }

    public function test_delete_image_with_non_existing_file()
    {
        Storage::fake('public');

        $service = new ImageUploadService();

        $result = $service->deleteImage('category/nonexistent.jpg');

        $this->assertFalse($result);
    }

    public function test_delete_image_with_empty_path()
    {
        $service = new ImageUploadService();

        $result = $service->deleteImage('');

        $this->assertFalse($result);
    }
}
