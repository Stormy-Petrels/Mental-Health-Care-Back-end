<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;
use App\Dtos\Patient\PatientReq;
use App\Models\Patient;
use App\Repositories\PatientRepository;

class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;
    private PatientRepository $patientRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
        $this->patientRepository = new PatientRepository();
    }
    
    public function profileDoctor($id){

        $doctor = $this->doctorRepository->getDoctorById($id);  
        
        return response()->json(
            [
            'message' => 'View profile doctor successfully',
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

    function updateHealthCondition(PatientReq $request ,$userId) 
    {
        $patient = new Patient($userId, $request->healthCondition, $request->note);
        $patientResult = $this->patientRepository->updateHealthCondition($patient ,$userId);

        return response()->json([
           'message' => 'Successfully',
            'payload' => $patientResult
        ]);
    }
}