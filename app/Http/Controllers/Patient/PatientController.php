<?php

namespace App\Http\Controllers\Patient;

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

class PatientController extends Controller
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

/**
 * @OA\Schema(
 *     schema="PatientProfileUpdateRequest",
 *     required={"name", "email"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe",
 *         description="The name of the patient"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="johndoe@example.com",
 *         description="The email address of the patient"
 *     )
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

    /**
     * @OA\Post(
     *     path="/profile/{id}",
     *     operationId="updateProfilePatient",
     *     tags={"Patient"},
     *     summary="Update patient profile",
     *     description="Update the profile of a specific patient",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/PatientProfileUpdateRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
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
                $patient->getId(),
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

    public function updatePatient(User $user, Patient $patient, string $id)
    {
        $user_sql = "UPDATE users SET email = ?, password = ?, fullName = ?, address = ?, phone = ?, urlImage = ? WHERE id = ?";
        $patient_sql = "UPDATE patients SET healthCondition = ?, note = ? WHERE userId = ?";

        DB::update($user_sql, [
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $id
        ]);
        DB::update($patient_sql, [
            $patient->getHealthCondition(),
            $patient->getNote(),
            $id
        ]);

        $newInformationUser = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);
        $newInformationPatient = DB::selectOne("
            SELECT patients.id, patients.healthCondition, patients.note
            FROM patients
            WHERE patients.userId = ?", [$id]
        );

        return new Patient(
            $newInformationPatient->id,
            $newInformationPatient->healthCondition,
            $newInformationPatient->note,
            new User(
                Role::Patient,
                $newInformationUser->email,
                $newInformationUser->password,
                $newInformationUser->fullName,
                $newInformationUser->address,
                $newInformationUser->phone,
                $newInformationUser->urlImage
            )
        );
    }
}