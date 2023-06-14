<?php

namespace App\Services;

use App\Models\Group;
use Arr;
use Carbon\Carbon;

class GroupService
{

    public function getGroupList($params, int $id)
    {
        $limit = Arr::get($params, 'limit', config('pagination.limit'));
        $sort = Arr::get($params, 'sort', config('pagination.sort'));
        $order = Arr::get($params, 'order', config('pagination.order'));
        return Group::select(['group.id', 'group.name', 'users.id as teacher_id', 'user_info.fullname as teacher_name'])
            ->join('users', 'users.id', 'group.user_id')
            ->join('user_info', 'users.id', 'user_info.user_id')
            ->whereDate('users.id', $id)
            ->orderBy($order, $sort)
            ->paginate($limit);
    }

    public function getGroupDetailById($id)
    {
        return Group::select(['group.id', 'group.name', 'users.id as teacher_id', 'user_info.fullname as teacher_name'])
            ->join('users', 'users.id', 'group.user_id')
            ->join('user_info', 'users.id', 'user_info.user_id')
            ->where('group.id', $id)
            ->first();
    }

    private function queryAssignmentList($id) {
        return Group::select(['assignment.*', 'question.*'])
            ->join('assignment', 'assignment.group_id', 'group.id')
            ->join('question', 'assignment.question_id', 'question.id')
            ->where('group.id', $id);
    }

    public function getAssignmentsEnded($id)
    {
        $to_day = Carbon::now();
        $query = $this->queryAssignmentList($id);
        return $query->whereDate('time_end', '<', $to_day)->get()->toArray();
    }

    public function getAssignmentsStarted($id)
    {
        $to_day = Carbon::now();
        $query = $this->queryAssignmentList($id);
        return $query->whereDate('time_start', '<', $to_day)->whereDate('time_end', '>=', $to_day)->get()->toArray();
    }

    public function getAssignmentsNotStart($id)
    {
        $to_day = Carbon::now();
        $query = $this->queryAssignmentList($id);
        return $query->whereDate('time_start', '>', $to_day)->get()->toArray();
    }
}
