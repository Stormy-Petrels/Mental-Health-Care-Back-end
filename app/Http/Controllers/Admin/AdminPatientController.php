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
}