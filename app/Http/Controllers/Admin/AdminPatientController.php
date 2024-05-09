<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use App\Repositories\DoctorRepository;
use App\Repositories\UserRepository;
use  App\Repositories\PatientRepository;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Dtos\Admin\PatientRes;
class AdminPatientController extends Controller
{
    private $adminRepository;
    private $doctorRepository;
    private $userRepository;
    private $patientRepository;
    public function __construct(AdminRepository $adminRepository, DoctorRepository $doctorRepository, UserRepository $userRepository, PatientRepository $patientRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->doctorRepository = $doctorRepository;
        $this->userRepository = $userRepository;
        $this->patientRepository = $patientRepository;
    }

    public function getAllPatients()
    {
        $patients = $this->patientRepository->getInformationPatients();
        $patientResponses = [];
        foreach ($patients as $patient) {
            $patientResponses[] = new PatientRes(
                $patient->getUserId(),
                $patient->getHealthCondition(),
                $patient->getNote(),
                $patient->user->getEmail(),
                $patient->user->getFullName(),
                $patient->user->getPassword(),
                $patient->user->getFullName(),
                $patient->user->getAddress(),
                $patient->user->getPhone(),
                $patient->user->getUrlImage()
            );
        }

        return response()->json([
            'message' => 'Successfully',
            'payload' => $patientResponses
        ]);
    }
}