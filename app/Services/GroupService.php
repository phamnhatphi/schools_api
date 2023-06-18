<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\Question;
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

    public function storeAssignmentGroupId($data, $id)
    {
        $assignment = [
            'assignment_type_id' => Arr::get($data, 'assignment_type_id'),
            'group_id' => $id,
            'title' => Arr::get($data, 'title'),
            'subtitle' => Arr::get($data, 'subtitle'),
            'time_start' => Arr::get($data, 'time_start'),
            'time_end' => Arr::get($data, 'time_end'),
            'question_id' => Arr::get($data, 'question_id'),
        ];
        return Assignment::insert($assignment);
    }

    public function updateAssignmentGroupId($data, $id, $assignment_id)
    {
        try {
            \DB::beginTransaction();
            $question_id = Arr::get($data, 'question_id');
            $question = [
                'user_id' => Arr::get($data, 'question_teacher_id'),
                'timeline' => Arr::get($data, 'timeline'),
                'answer' => Arr::get($data, 'question_answer'),
                'content' => Arr::get($data, 'question_content'),
                'has_answer' => Arr::get($data, 'question_has_answer'),
            ];
            Question::where('id', $question_id)->update($question);

            $assignment = [
                'assignment_type_id' => Arr::get($data, 'assignment_type_id'),
                'group_id' => $id,
                'title' => Arr::get($data, 'title'),
                'subtitle' => Arr::get($data, 'subtitle'),
                'time_start' => Arr::get($data, 'time_start'),
                'time_end' => Arr::get($data, 'time_end'),
                'question_id' => $question_id,
            ];
            Assignment::where('id', $assignment_id)->update($assignment);
            \DB::commit();
            return true;
        } catch (\Throwable $th) {
            \Log::debug($th);
            \DB::rollBack();
            return false;
        }
    }
    
    public function deleteAssignmentGroupId($assignment_id) {
        return Assignment::where('id', $assignment_id)->delete($assignment_id);
    }
}
