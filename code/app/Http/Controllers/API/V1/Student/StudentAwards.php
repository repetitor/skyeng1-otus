<?php


namespace App\Http\Controllers\API\V1\Student;


use App\Models\StudentsAwards as StudentsAwardsModel;
use Illuminate\Support\Facades\DB;

class StudentAwards
{
    public function receiveAwards( int $student_id ) : void
    {
        $awards = DB::table('awards')->get();
        foreach ( $awards as $award ) {
            switch ( $award->alias ) {
                case '5_tasks_rated_above_6':
                    $this->receiveAward5TasksRatedAbove6( $student_id, $award->id );
                    break;
                case 'all_module_tasks':

                    break;
                default:
                    break;
            }

        }
    }

    public function receiveAward5TasksRatedAbove6(int $student_id, int $award_id) : bool
    {
        $result = DB::select('
            SELECT
                id
            FROM students_awards
            WHERE
                students_awards.student_id = :id
            AND
               award_id = :award

        ', ['id' => $student_id,'award' => $award_id] );
        if ( !empty($result) && !empty($result[0]) )
        {
            return false;
        }

        $result = DB::select('
            SELECT
                COUNT(students_tasks.id) AS count_tasks
            FROM students_tasks
            WHERE
                students_tasks.student_id=:id
            AND
               students_tasks.rating > 6

        ', ['id' => $student_id] );

        if ( !empty($result) && !empty($result[0]) && (int) $result[0]->count_tasks > 6 )
        {
            $student_awards = new StudentsAwardsModel();
            $student_awards->fill([
                'student_id' => $student_id,
                'award_id' => $award_id,
                'params' => '',
            ])->save();
        }

        return true;
    }
}
