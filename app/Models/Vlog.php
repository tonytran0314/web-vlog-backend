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

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('order', function(Builder $query){
            $query->orderBy('created_at', 'desc');
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
