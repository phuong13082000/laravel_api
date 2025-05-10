<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'color',
        'description',
        'parent_id',
    ];

    protected static function booted(): void
    {
        static::saving(function ($category) {
            if ($category->parent) {
                $category->depth = $category->parent->depth + 1;
            } else {
                $category->depth = 0;
            }
        });
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
