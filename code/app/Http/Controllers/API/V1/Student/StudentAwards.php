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
                    $this->receiveAwardAllModuleTasks( $student_id, $award->id );
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
        if ( !empty($result) && !empty($result[0]) ) {
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

        if ( !empty($result) && !empty($result[0]) && (int) $result[0]->count_tasks > 6 ) {
            $student_awards = new StudentsAwardsModel();
            $student_awards->fill([
                'student_id' => $student_id,
                'award_id' => $award_id,
                'params' => '',
            ])->save();
        }

        return true;
    }
    public function receiveAwardAllModuleTasks(int $student_id, int $award_id) : bool
    {
        $result = DB::select('
            SELECT
                params
            FROM students_awards
            WHERE
                students_awards.student_id = :id
            AND
               award_id = :award
        ', ['id' => $student_id,'award' => $award_id] );

        $modules_archived = [];
        foreach ( $result as $row ) {
            $row->params = json_decode( $row->params, 1 );
            $modules_archived[] = $row->params['module_id'];
        }

        $result_modules_tasks = DB::select('
            SELECT
                tasks.module_id,
                COUNT(id) AS tasks
            FROM tasks
            GROUP BY tasks.module_id
        ',);
        $modules_tasks = [];
        foreach ($result_modules_tasks as $mt) {
            $modules_tasks[ $mt->module_id ] = $mt->tasks;
        }

        $result_students_tasks = DB::select('
            SELECT
                tasks.module_id,
                COUNT(students_tasks.id) AS rated_tasks
            FROM students_tasks
            LEFT JOIN tasks on students_tasks.task_id = tasks.id
            WHERE
                students_tasks.student_id = :id
            GROUP BY tasks.module_id
        ', ['id' => $student_id,] );
        $awards_to_receive = [];
        foreach ($result_students_tasks as $st) {
            if ( $st->rated_tasks == $modules_tasks[ $st->module_id ] && !in_array( $st->module_id, $modules_archived ) ) {
                $awards_to_receive[] = $st->module_id;
            }
        }

        if (empty($awards_to_receive)) {
            return false;
        }

        foreach ( $awards_to_receive as $module_id ) {
            $student_awards = new StudentsAwardsModel();
            $student_awards->fill([
                'student_id' => $student_id,
                'award_id' => $award_id,
                'params' => json_encode(['module_id'=>$module_id]),
            ])->save();
        }
        return true;
    }

}
