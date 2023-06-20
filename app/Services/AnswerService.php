<?php

namespace App\Services;

use App\Models\Answer;
use Arr;

class AnswerService
{

    public function answerList($group_id, $assignment_id)
    {
        $results = Answer::select(['answer.*', 'user_info.fullname as student_name', 'assignment.id as assignments_id'])
            ->join('assignment', 'assignment.id', 'answer.assignment_id')
            ->join('group', 'group.id', 'assignment.group_id')
            ->join('users', 'users.id', 'group.user_id')
            ->join('user_info', 'user_info.user_id', 'users.id')
            ->where('group.id', $group_id)
            ->where('assignment.id', $assignment_id)
            ->get()
            ->toArray();
        return $results;
    }
}
