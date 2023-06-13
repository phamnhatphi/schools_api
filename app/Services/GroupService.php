<?php

namespace App\Services;

use App\Models\Group;
use Arr;

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
            ->where('users.id', $id)
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
}
