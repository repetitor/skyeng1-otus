<?php


namespace App\Http\Controllers\API\V1\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Task;

class TaskController extends Controller
{
    const MAX_RATING = 10;
    const MIN_RAITNG = 1;

    public static function validateRating( int $rating ) : bool
    {
        if ( self::MIN_RAITNG < 1 && self::MAX_RATING > 10 ) {
            return false;
        }
        return true;
    }
}
