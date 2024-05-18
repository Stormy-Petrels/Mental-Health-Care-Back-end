<?php

namespace App\Http\Controllers\Admin;

use App\Dtos\Admin\DoctorReq;
use App\Repositories\DoctorRepository;
use App\Dtos\Admin\DoctorRes;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;

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
                $doctor->user->getPassword(),
                $doctor->user->getFullName(),
                $doctor->user->getAddress(),
                $doctor->user->getPhone(),
                $doctor->user->getUrlImage(),
                $doctor->user->getStatus(),
            );
        }

        return response()->json([
            'status'=>200,
            'message' => 'View list doctors successfully',
            'data' => $doctorResponses
        ]);
    }

    public function createDoctor(DoctorReq $request)
    {
        $user = new User($request->role, $request->email, $request->password, $request->fullName,  $request->address, $request->phone, $request->urlImage, $request->isActive);
        $doctor = new Doctor($user->getId(), $request->description, $request->major);
        $result = $this->doctorRepository->createDoctor($user, $doctor);

        $newDoctor = new DoctorRes(
            $result->getUserId(),
            $result->getDescription(),
            $result->getMajor(),
            $user->getEmail(),
            $user->getFullName(),
            $user->getPassword(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $user->getStatus(),
        );

        return response()->json([
            'status' =>200,
            'message' => 'Create doctor successfully',
            'payload' => $newDoctor
        ]);
    }
}