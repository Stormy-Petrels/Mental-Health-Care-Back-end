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
use App\Dtos\Admin\PatientReq;
use App\Dtos\Doctor\ProfileRes;
use App\Dtos\Patient\UpdateProfileRes;

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
    /**
     * @OA\Get(
     *     path="/api/admin/patients",
     *     summary="Get list of patients",
     *     description="Returns list of patients",
     *     operationId="getPatientsList",
     *     tags={"Patient"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="payload",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PatientRes")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     * @OA\Schema(
     *     schema="PatientRes",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="healthCondition",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="note",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="password",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="fullName",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="phone",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="image",
     *         type="string"
     *     )
     * )
     */
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


    public function createPatient(PatientReq $request)
    {   
        $user = new User($request->role, $request->email, $request->password, $request->fullName, $request->address, $request->phone,  $request->urlImage, $request->isActive);
        $doctor = new Patient($user->getId(), $request->healthCondition, $request->note);
        
        $patient = $this->patientRepository->createPatient($user, $doctor);

        $result = new PatientRes(
            $patient->getUserId(),
            $patient->getHealthCondition(),
            $patient->getNote(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $user->getStatus(),
        );
        return response()->json([
            'status' => 200,
            'message' => 'Add new patient successfully',
            'data' => $result
        ]);
    }

    public function updateProfilePatient(UpdateProfileRes $req)
    {
        $user = new User(
            Role::Patient,
            $req->email,
            $req->password,
            $req->fullName,
            $req->address,
            $req->phone,
            $req->image
        );
        $patient = new Patient(
            $req->id,
            $req->healthCondition,
            $req->note
        );
        $patient = $this->patientRepository->updatePatient($user, $patient, $req->id);
        return response()->json([
            'status' => 200,
            'message' => 'Patient profile updated successfully',
            'data' => new ProfileRes(
                $patient->getUserId(),
                $patient->user->getEmail(),
                $patient->user->getPassword(),
                $patient->user->getFullName(),
                $patient->user->getAddress(),
                $patient->user->getPhone(),
                $patient->user->getUrlImage(),
                $patient->getHealthCondition(),
                $patient->getNote()
            )
        ]);
    }
}