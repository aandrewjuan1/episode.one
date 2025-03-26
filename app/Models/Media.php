<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type', // e.g., Manga, Anime, Book, Movie
        'status', // e.g., Watching, Completed, On Hold, Dropped, Plan to Watch
        'overview',
        'image_path',
        'user_id', // Foreign key to users table
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_media');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeSearch($query, $searchQuery): void
    {
        $searchQuery = trim($searchQuery);

        $query->where('user_id', Auth::id())
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', "%{$searchQuery}%") // Search in the 'title' column
                        ->orWhere('type', 'like', "%{$searchQuery}%")  // Search in the 'type' column
                        ->orWhereHas('genres', function ($query) use ($searchQuery) {
                            $query->where('name', 'like', "%{$searchQuery}%");
                        });
            });
    }
}
