<?php

namespace App\Services;

class AggregationService
{
    public function aggregateStudentByTime(int $studentId)
    {
        return 'time-aggregation';
    }

    public function aggregateStudentByTasksSkills(int $studentId)
    {
        return 'tasks-skills-aggregation';
    }

    public function aggregateStudentByCourses(int $studentId)
    {
        return 'courses-aggregation';
    }
}
