<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected $disk = 'public';

    public function uploadImage(
        UploadedFile $file,
        string       $path = 'images'
    ): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $this->buildPath($path, $filename);

        Storage::disk($this->disk)->put($filePath, file_get_contents($file));

        return $filePath;
    }

    public function updateImage(
        UploadedFile $file,
        ?string      $oldImagePath = null,
        string       $path = 'images'
    ): string
    {
        if (!empty($oldImagePath)) {
            $this->deleteImage($oldImagePath);
        }

        return $this->uploadImage($file, $path);
    }

    public function deleteImage(string $imagePath): bool
    {
        if (empty($imagePath)) {
            return false;
        }

        if ($this->imageExists($imagePath)) {
            return Storage::disk($this->disk)->delete($imagePath);
        }

        return false;
    }

    protected function buildPath(string $path, string $filename): string
    {
        return rtrim($path, '/') . '/' . $filename;
    }

    public function imageExists(?string $imagePath): bool
    {
        if (empty($imagePath)) {
            return false;
        }

        return Storage::disk($this->disk)->exists($imagePath);
    }

    public function getImageUrl(string $imagePath): ?string
    {
        if (empty($imagePath)) {
            return null;
        }

        return Storage::disk($this->disk)->url($imagePath);
    }
}
