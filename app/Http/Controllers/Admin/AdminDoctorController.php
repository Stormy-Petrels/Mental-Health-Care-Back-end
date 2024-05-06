<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DoctorRepository;
use App\Dtos\Admin\DoctorRes;
use App\Http\Controllers\Controller;

class AdminDoctorController extends Controller
{
    // private AdminRepository $adminRepository;
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }

    public function getAllDoctors()
    {
        $doctors = $this->doctorRepository->queryAllDoctors();
        // dd($doctors);
        $doctorResponses = [];

        foreach ($doctors as $doctor) {
            $doctorResponses[] = new DoctorRes(
                $doctor->getUserId(),
                $doctor->getDescription(),
                $doctor->getMajor(),
                $doctor->user->getEmail(),
                $doctor->user->getFullName(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage()
            );
        }

        return response()->json([
            'message' => 'Successfully',
            'payload' => $doctorResponses
        ]);
    }
}
