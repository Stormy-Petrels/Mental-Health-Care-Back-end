<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;
use App\Dtos\Doctor\UpdateProfileReq;
use App\Dtos\Doctor\MajorReq;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Doctor",
 *     description="API Endpoints for Doctor"
 * )
 */
class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }
  /**
     * @OA\Get(
     *     path="/api/doctor/profile/{id}",
     *     summary="View Profile Doctor",
     *     tags={"Doctor"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the doctor to view profile",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="View profile doctor successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="View profile doctor successfully"),
     *             @OA\Property(property="payload", type="object", ref="#/components/schemas/ProfileRes")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Doctor not found")
     * )
     */
    public function profileDoctor($id){

        $doctor = $this->doctorRepository->getDoctorById($id);  
        
        return response()->json(
            [
            'status'=>200,
            'message' => 'View profile doctor successfully',
            'doctor' => new ProfileRes(
                $doctor->getUserId(),
                $doctor->user->getEmail(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
                $doctor->getDescription(),
                $doctor->getMajor(),
            )
            ]
        );
    }
/**
     * @OA\Post(
     *     path="/api/updateProfile/doctor/{id}",
     *     summary="Update Profile Doctor",
     *     tags={"Doctor"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", description="ID of the doctor"),
     *             @OA\Property(property="email", type="string", description="Email of the doctor"),
     *             @OA\Property(property="password", type="string", description="Password of the doctor"),
     *             @OA\Property(property="fullName", type="string", description="Full name of the doctor"),
     *             @OA\Property(property="address", type="string", description="Address of the doctor"),
     *             @OA\Property(property="phone", type="string", description="Phone number of the doctor"),
     *             @OA\Property(property="image", type="string", nullable=true, description="Image URL of the doctor"),
     *             @OA\Property(property="description", type="string", nullable=true, description="Description of the doctor"),
     *             @OA\Property(property="majorId", type="string", description="Major ID of the doctor")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Doctor profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Doctor profile updated successfully"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/ProfileRes")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    public function updateProfileDoctor(UpdateProfileReq $req)
    {
        $user = new User(
            Role::Doctor,
            $req->email,
            $req->password,
            $req->fullName,
            $req->address,
            $req->phone,
            $req->image ?? ''
        );

        $doctor = new Doctor(
            $req->id,
            $req->description,
            $req->majorId
        );
        $doctor = $this->doctorRepository->updateDoctor($user, $doctor, $req->id);
        return response()->json([
            'message' => 'Doctor profile updated successfully',
            'data' => new ProfileRes(
                $doctor->getUserId(),
                $doctor->user->getEmail(),
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
                $doctor->getDescription(),
                $doctor->getMajor(),
            )
        ]);
    }

    public function getAllMajors(){
        $majors = $this->doctorRepository->getAllMajors();
        return response()->json([
            'message' => 'Majors',
            'data' => $majors
        ]);
    }

}