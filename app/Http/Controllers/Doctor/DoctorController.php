<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;
use OpenApi\Annotations as OA;

/**
 * @group Doctor Profile
 *
 * APIs for managing doctor profile.
 */
class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }
 

    
    /**
     * Retrieve the profile of a specific doctor.
     *
     * @OA\Get(
     *     path="/api/doctor/profile/{id}",
     *     tags={"Doctor Profile"},
     *     summary="Retrieve the profile of a specific doctor.",
     *     description="Retrieve the profile of a specific doctor by ID.",
     *     operationId="profileDoctor",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the doctor.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile Successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Profile Successfully"
     *             ),
     *             @OA\Property(
     *                 property="payload",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Dr. John Smith specializes in cardiology."
     *                 ),
     *                 @OA\Property(
     *                     property="major",
     *                     type="string",
     *                     example="Cardiology"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="doctorLoan@gmail.com.com"
     *                 ),
     *                 @OA\Property(
     *                     property="full_name",
     *                     type="string",
     *                     example="Doctor Ms.Huynh Thi To Loan"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     example="Tam Dan, Phu Ninh, Quang Nam"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="0878138854"
     *                 ),
     *                 @OA\Property(
     *                     property="url_image",
     *                     type="string",
     *                     example="https://cdn.sforum.vn/sforum/wp-content/uploads/2023/12/hinh-nen-chibi-76.jpg"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Doctor not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Doctor not found"
     *             )
     *         )
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dtos\Doctor\ProfileReq  $req
     * @return \Illuminate\Http\Response
     */
    public function profileDoctor(ProfileReq $req)
    {
        $doctor = $this->doctorRepository->getDoctorById($req->id);  
        
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
        
        return response()->json([
            'message' => 'Profile Successfully',
            'payload' => new ProfileRes(
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
        ]);
    }
}
