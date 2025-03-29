<?php

namespace App\Enums;

enum MediaStatus: string
{
    case WATCHING = 'Watching';
    case READING = 'Reading';
    case COMPLETED = 'Completed';
    case ON_HOLD = 'On Hold';
    case DROPPED = 'Dropped';
    case PLAN_TO_WATCH = 'Plan to Watch';
}
