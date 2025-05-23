<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function media()
    {
        return $this->belongsToMany(Media::class, 'genre_media');
    }
}
