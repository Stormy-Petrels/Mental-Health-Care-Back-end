<?php

namespace App\Http\Controllers\Admin;

use App\Dtos\Common\StatusRes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Repositories\AdminRepository;

class AdminController extends Controller
{
    private UserRepository $usersRepository;
    private AdminRepository $adminRepository;
    public function __construct()
    {
        $this->usersRepository = new UserRepository();
        $this->adminRepository = new AdminRepository();
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

    public function getStats()
    {
        $stats = $this->adminRepository->getStats();
        return response()->json([
            'status' => 200,
            'data' => $stats
        ]);
    }

    public function getDoctors()
    {
        $doctors = $this->adminRepository->getDoctors();
        return response()->json([
            'status' => 200,
            'data' => $doctors
        ]);
    }

    public function getMajors()
    {
        $majors = $this->adminRepository->getMajors();
        return response()->json([
           'status' => 200,
            'data' => $majors
        ]);
    }
    
}