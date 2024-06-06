<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Dtos\Admin\DoctorReq;
use App\Repositories\DoctorRepository;
use App\Dtos\Admin\DoctorRes;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
            'status' => 200,
            'message' => 'View list doctors successfully',
            'data' => $doctorResponses
        ]);
    }



    public function createDoctor(Request $request)
{
    $doctorReq = new DoctorReq($request);
    $user = new User(
        $doctorReq->role,
        $doctorReq->email,
        $doctorReq->password,
        $doctorReq->fullName,
        $doctorReq->address,
        $doctorReq->phone,
        $doctorReq->isActive
    );

    if ($request->hasFile('urlImage')) {
        $file = $request->file('urlImage');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images'), $fileName);
        $user->setUrlImage($fileName); 
    }
    $doctor = new Doctor(
        $user->getId(),
        $doctorReq->description,
        $doctorReq->major
    );
    $result = $this->doctorRepository->createDoctor($user, $doctor);

    
    $this->doctorRepository->createDoctorCalendars($doctor->getId());

    $newDoctor = new DoctorRes(
        $result->getUserId(),
        $result->getDescription(),
        $result->getMajor(),
        $user->getEmail(),
        $user->getPassword(),
        $user->getFullName(),
        $user->getAddress(),
        $user->getPhone(),
        $user->getUrlImage(),
        "1"
    );

    return response()->json([
        'status' => 200,
        'message' => 'Create doctor successfully',
        'payload' => $newDoctor
    ]);
}

    
}