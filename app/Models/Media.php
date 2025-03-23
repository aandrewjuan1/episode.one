<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type', // e.g., Manga, Anime, Book, Movie
        'status', // e.g., Watching, Completed, On Hold, Dropped, Plan to Watch
        'genre',
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
}
