<?php

namespace App\Enums;

enum MediaType: string
{
    case MANGA = 'Manga';
    case ANIME = 'Anime';
    case BOOK = 'Book';
    case MOVIE = 'Movie';
}
