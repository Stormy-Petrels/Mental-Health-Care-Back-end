<?php

namespace App\Http\Controllers\Patient;

use App\Dtos\Admin\DoctorRes;
use App\Dtos\Patient\ViewInformationDoctorRes;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use App\Dtos\Patient\ProfileRes;
use App\Dtos\Patient\UpdateProfileRes;
use Illuminate\Support\Facades\DB;
use App\Repositories\DoctorRepository;

/**
 * @OA\Tag(
 *     name="Patient",
 *     description="API Endpoints for Patient"
 * )
 */
class PatientController extends Controller
{
    private $patientRepository;
    private $doctorRepository;

    public function __construct(PatientRepository $patientRepository, DoctorRepository $doctorRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/profile/{id}",
     *     summary="View Profile Patient",
     *     tags={"Patient"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient to view profile",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="View profile patient successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="View profile patient successfully"),
     *             @OA\Property(property="payload", type="object", ref="#/components/schemas/ProfileRes")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Patient not found")
     * )
     */
    public function profilePatient($id)
    {
        $patient = $this->patientRepository->getPatientById($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json([
            'status' =>200,
            'message' => 'Patient data retrieved successfully',
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
            ),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/profile/{id}",
     *     summary="Update Profile Patient",
     *     tags={"Patient"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", description="ID of the patient"),
     *             @OA\Property(property="email", type="string", description="Email of the patient"),
     *             @OA\Property(property="password", type="string", description="Password of the patient"),
     *             @OA\Property(property="fullName", type="string", description="Full name of the patient"),
     *             @OA\Property(property="address", type="string", description="Address of the patient"),
     *             @OA\Property(property="phone", type="string", description="Phone number of the patient"),
     *             @OA\Property(property="image", type="string", nullable=true, description="Image URL of the patient"),
     *             @OA\Property(property="healthCondition", type="string", nullable=true, description="HealthCondition of the patient"),
     *             @OA\Property(property="note", type="string", description="Note of the patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Patient profile updated successfully"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/ProfileRes")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
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
            'status'=> 200,
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
    /**
     * @OA\Get(
     *     path="/api/detail/{id}",
     *     operationId="viewInformationDoctor",
     *     tags={"Patient"},
     *     summary="View information of a doctor",
     *     description="Retrieve information of a specific doctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the doctor",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor information retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="View profile doctor successfully"
     *             ),
     *             @OA\Property(
     *                 property="payload",
     *                 type="object",
     *                 ref="#/components/schemas/ViewInformationDoctorRes"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */
    public function ViewInformationDoctor($id)
    {
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
                    $doctor->user->getUrlImage()
                )
            ]
        );
    }


    public function viewListDoctors()
    {
        $doctors = $this->doctorRepository->queryAllDoctors();
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
            'message' => 'Successfully retrieved list of doctors',
            'payload' => $doctorResponses
        ]);
    }
}