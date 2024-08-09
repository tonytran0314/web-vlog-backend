<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Vlog extends Model
{
    use HasFactory;

    protected $table = 'vlog';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'video',
        'public',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($vlog) {
            $vlog->slug = self::generateUniqueSlug($vlog->title);
        });

        static::updating(function ($vlog) {
            $vlog->slug = self::generateUniqueSlug($vlog->title, $vlog->id);
        });

        static::addGlobalScope('order', function(Builder $query){
            $query->orderBy('created_at', 'desc');
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeSlug(Builder $query, $slug): void {
        $query->where('slug', $slug);
    }
}
