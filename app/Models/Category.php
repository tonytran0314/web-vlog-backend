<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'slug'
    ];

    public function vlogs(): BelongsToMany
    {
        return $this->belongsToMany(Vlog::class)->orderBy('created_at', 'desc');
    }

    public function scopeSlug(Builder $query, $slug): void {
        $query->where('slug', $slug);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = self::generateUniqueSlug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = self::generateUniqueSlug($category->name, $category->id);
        });
    }

    // this one should be a helper
    public static function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;
        while (self::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
