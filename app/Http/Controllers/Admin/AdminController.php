<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\AdminRepository;

class AdminController extends Controller
{
    private UserRepository $userRepository;
    private AdminRepository $patientRepository;


    public function __construct()
    {
        $this->patientRepository = new AdminRepository();
        $this->userRepository = new UserRepository();
    }

    function getAllDoctors(): array
    {
        $admins = new AdminRepository();
        return $admins->queryAllDoctors();
    }
}
