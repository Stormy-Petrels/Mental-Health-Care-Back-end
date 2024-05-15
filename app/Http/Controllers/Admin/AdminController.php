<?php

namespace App\Http\Controllers\Admin;

use App\Dtos\Common\StatusRes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\Role;
class AdminController extends Controller
{
    private UserRepository $usersRepository;
    public function __construct()
    {
        $this->usersRepository = new UserRepository();
    }

    public function updateStatusUsersActive($userId)
    {
        $result = $this->usersRepository->updateStatusUsersActive($userId);

        $user = new StatusRes($result->getRole()->getValue(), $result->getEmail(), $result->getFullName(), "1");
        return response([
            'message' => "Updated successfully status user (active)",
            'User' => $user,
        ]);
    }

    public function updateStatusUsersInactive($userId)
    {
        $result = $this->usersRepository->updateStatusUsersInactive($userId);

            $user = new StatusRes($result->getRole()->getValue(), $result->getEmail(), $result->getFullName(), "0");
            return response([
                'message' => "Updated successfully status user (blocked)",
                'User' => $user,
            ]);
    }
}
