<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DoctorRepository;
use App\Dtos\Admin\DoctorRes;
use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/doctors",
 *     summary="Get all doctors",
 *     tags={"Doctors"},
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation"
 *     ),
 *     @OA\Response(response=401, description="Unauthenticated"),
 * )
 */

class AdminDoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }

    public function getAllDoctors()
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
            'message' => 'Successfully',
            'payload' => $doctorResponses
        ]);
    }
}
