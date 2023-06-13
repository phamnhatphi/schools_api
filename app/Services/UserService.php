<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function getMe(int $id)
    {
        return User::join('user_info', 'users.id', 'user_info.user_id')
            ->join('role', 'users.role_id', 'role.id')
            ->where('users.id', $id)
            ->first();
    }
}
