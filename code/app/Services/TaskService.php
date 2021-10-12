<?php

namespace App\Services;

class TaskService
{
    const MIN_RAITNG = 1;
    const MAX_RATING = 10;

    public static function validateRating( int $rating ) : bool
    {
        if ( $rating < self::MIN_RAITNG || $rating > self::MAX_RATING ) {
            return false;
        }
        return true;
    }
}
