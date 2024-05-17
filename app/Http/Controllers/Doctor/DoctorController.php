<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;
use App\Dtos\Doctor\UpdateProfileReq;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }
    
    public function profileDoctor($id){

        $doctor = $this->doctorRepository->getDoctorById($id);  
        
        return response()->json(
            [
            'message' => 'View profile doctor successfully',
            'payload' => new ProfileRes(
                $doctor->getUserId(),
                $doctor->user->getEmail(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
                $doctor->getDescription(),
                $doctor->getMajor(),
            )
            ]
        );
    }

    public function updateProfileDoctor(UpdateProfileReq $req)
    {
        $user = new User(
            Role::Doctor,
            $req->email,
            $req->password,
            $req->fullName,
            $req->address,
            $req->phone,
            $req->image ?? ''
        );

        $doctor = new Doctor(
            $req->id,
            $req->description,
            $req->majorId
        );
        $doctor = $this->doctorRepository->updateDoctor($user, $doctor, $req->id);
        return response()->json([
            'message' => 'Doctor profile updated successfully',
            'data' => new ProfileRes(
                $doctor->getUserId(),
                $doctor->user->getEmail(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
                $doctor->getDescription(),
                $doctor->getMajor(),
            )
        ]);
    }

}