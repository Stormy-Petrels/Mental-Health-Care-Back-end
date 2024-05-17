<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DoctorRepository;
use App\Http\Controllers\Controller;
use App\Dtos\Admin\DoctorRes;


class AdminDoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }

    /**
 * @OA\Get(
 *     path="/Admin/getAllDoctor",
 *     operationId="getAllDoctors",
 *     tags={"Doctors"},
 *     summary="Get all doctors",
 *     description="Retrieve a list of all doctors from the database",
 *     @OA\Response(
 *         response=200,
 *         description="A list of doctors",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Successfully"
 *             ),
 *             @OA\Property(
 *                 property="payload",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/DoctorRes")
 *             )
 *         )
 *     )
 * )
 */
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
                $doctor->user->getStatus() == null ? "1" :"null"
            );
        }

        return response()->json([
            'message' => 'Successfully',
            'payload' => $doctorResponses
        ]);
    }
}