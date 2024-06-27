<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name'
    ];

    public function vlogs(): BelongsToMany
    {
        return $this->belongsToMany(Vlog::class)->orderBy('created_at', 'desc');
    }

    public function scopeSlug(Builder $query, $slug): void {
        $query->where('slug', $slug);
    }
}
