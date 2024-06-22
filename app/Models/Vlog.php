<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Vlog extends Model
{
    use HasFactory;

    protected $table = 'vlog';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'public',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeLatest(Builder $query): void {
        $query->where('created_at', 'desc');
    }
}
