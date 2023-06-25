<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\User;
use Arr;

class StudentService
{

    public function answerDetail($group_id, $assignment_id, $user_id)
    {
        $user_id = 2;
        $results = Answer::select(['answer.*'])
            ->join('assignment', 'assignment.id', 'answer.assignment_id')
            ->join('users', 'users.id', 'answer.student_id')
            ->join('group', 'assignment.group_id', 'group.id')
            ->join('user_info', 'user_info.user_id', 'users.id')
            ->where('group.id', $group_id)
            ->where('assignment.id', $assignment_id)
            ->where('users.id', $user_id)
            ->first();
        return $results ?? [];
    }
}
