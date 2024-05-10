<?php

namespace App\Http\Controllers\Patient;

use App\Dtos\Patient\ViewInformationDoctorRes;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use App\Dtos\Patient\ProfileRes;
use App\Repositories\DoctorRepository;

class PatientController extends Controller
{
    private PatientRepository $patientRepository;
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->patientRepository = new PatientRepository();
        $this->doctorRepository = new DoctorRepository();
    }
    public function index($id)
    {
        $patient = $this->patientRepository->getPatientById($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json([
            'message' => 'Patient data retrieved successfully',
            'data' => new ProfileRes(
                    $patient->getId(),
                    $patient->user->getEmail(),
                    $patient->user->getPassword(),
                    $patient->user->getFullname(),
                    $patient->user->getAddress(),
                    $patient->user->getPhone(),
                    $patient->user->getUrlImage(),
                    $patient->getHealthCondition(),
                    $patient->getNote()
            ),
        ]);
    }
    

    public function update(Request $request, string $id)
    {
        $select = new PatientRepository();

        // Validate input data
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'newPassword' => 'nullable|string|min:6',
            'phone' => 'required|string',
            'address' => 'required|string',
            'healthCondition' => 'nullable|string',
            'note' => 'nullable|string',
        ]);


        if ($validator->fails()) {
            return redirect('/profile/' . $id)
                ->withErrors($validator)
                ->withInput();
        }
        // Proceed with updating the patient
        $password = $request->input('password');
        $newPassword = $request->input('newPassword');
        if (!empty($newPassword)) {
            $password = $newPassword;
        }


        // Update user information
        $updateUser = new User(
            Role::Doctor,
            '',
            $password,
            $request->input('name'),
            $request->input('phone'),
            $request->input('address'),
            ''
        );
        $updatePatient = new Patient(
            $id,
            $request->input('healthCondition'),
            $request->input('note')
        );

        $patient = $select->updatePatient($updateUser, $updatePatient);

        if ($patient == null) {
            //dd($patient);
return redirect('/profile/' . $id)->with('success', 'Patient updated successfully');
        }
    }

    public function ViewInformationDoctor($id){
        $doctor = $this->doctorRepository->getDoctorById($id);
        return response()->json(
            [
            'message' => 'View profile doctor successfully',
            'payload' => new ViewInformationDoctorRes(
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