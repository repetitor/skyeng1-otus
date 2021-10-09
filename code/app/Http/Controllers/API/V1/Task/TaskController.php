<?php


namespace App\Http\Controllers\API\V1\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Task;

class TaskController extends Controller
{
    const MIN_RAITNG = 1;
    const MAX_RATING = 10;

    public static function validateRating( int $rating ) : bool
    {
        if ( $rating < self::MIN_RAITNG && $rating > self::MAX_RATING ) {
            return false;
        }
        return true;
    }
}
