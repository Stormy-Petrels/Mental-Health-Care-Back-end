<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;

class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }
    
    public function profileDoctor(ProfileReq $req){

        $doctor = $this->doctorRepository->getDoctorById($req->id);  
        
        return response()->json(
            [
            'message' => 'Profile Successfully',
            'payload' => new ProfileRes(
                $doctor->getUserId(),
                $doctor->getDescription(),
                $doctor->getMajor(),
                $doctor->user->getEmail(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
            )
            ]
        );
    }
}
