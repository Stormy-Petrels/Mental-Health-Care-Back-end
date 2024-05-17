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
     * @OA\Post(
     * path="/api/profile/{id}",
     * operationId="Update Post",
     * tags={"Patient"},
     * summary="User Update Post",
     * description="Update Post here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password", "fullName", "address", "phone", "image"},
     *               @OA\Property(property="email", type="string", example="patient@gmail.com"),
     *               @OA\Property(property="password", type="string", example="Patient123@.")
     *               @OA\Property(property="fullName", type="string", example="Patient1")
     *               @OA\Property(property="address", type="string", example="DN")
     *               @OA\Property(property="phone", type="string", example="0987654321")
     *               @OA\Property(property="image", type="url", example="aaaaaaaaaaaaaaaaaa")
     *         )
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Post Created  Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     */
    public function profilePatient($id)
    {
        $patient = $this->patientRepository->getPatientById($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json([
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


    public function updateProfilePatient(UpdateProfileRes $req)
    {
        $user = new User(
            Role::Patient,
            $req->email,
            $req->password,
            $req->fullName,
            $req->address,
            $req->phone,
            $req->image ?? ''
        );
        $patient = new Patient(
            $req->id,
            $req->healthCondition,
            $req->note
        );
        $patient = $this->patientRepository->updatePatient($user, $patient, $req->id);
        return response()->json([
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
