<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Session;
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
                $patient->user->getFullName(),
                $patient->user->getPassword(),
                $patient->user->getAddress(),
                $patient->user->getPhone(),
                $patient->user->getUrlImage(),
                $patient->getHealthCondition(),
                $patient->getNote()
            ),
        ]);
    }


    public function updateProfile(Request $request, string $id)
    {
        $select = new PatientRepository();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'newPassword' => 'nullable|string|min:6',
            'fullName' => 'required|string',
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

        $password = $request->input('password');
        $newPassword = $request->input('newPassword');
        if (!empty($newPassword)) {
            $password = $newPassword;
        }

        // Update user information
        $updateUser = new User(
            Role::Patient,
            $request->input('email'),
            $password,
            $request->input('fullName'),
            $request->input('phone'),
            $request->input('address'),
            $request->input('urlImage') ?? ''
        );
        $updatePatient = new Patient(
            $id,
            $request->input('healthCondition'),
            $request->input('note')
        );

        $patient = $select->updatePatient($updateUser, $updatePatient);

        if ($patient != null) {
            return response()->json([
                'error' => 'Failed to update patient profile'
            ], 500);
        }
        return response()->json([
            'message' => 'Patient profile updated successfully',
            'data' => new ProfileRes(
                $updatePatient->getId(),
                $updateUser->getEmail(),
                $updateUser->getPassword(),
                $updateUser->getFullName(),
                $updateUser->getAddress(),
                $updateUser->getPhone(),
                $updateUser->getUrlImage(),
                $updatePatient->getHealthCondition(),
                $updatePatient->getNote()
            )
        ]);
    }
}