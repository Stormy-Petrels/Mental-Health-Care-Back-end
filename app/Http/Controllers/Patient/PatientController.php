<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use App\Dtos\Patient\ProfileRes;

class PatientController extends Controller
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }
    public function profilePatient($id)
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
                $patient->user->getFullName(),
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
}