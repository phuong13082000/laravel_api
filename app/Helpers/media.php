<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        if (!$path) return null;

        return asset('storage/' . ltrim($path, '/'));
    }
}

if (!function_exists('media_exists')) {
    function media_exists(?string $path): bool
    {
        return $path && Storage::disk('public')->exists($path);
    }
}
