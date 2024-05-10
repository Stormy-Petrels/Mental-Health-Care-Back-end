<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Repositories\DoctorRepository;
use App\Dtos\Doctor\ProfileReq;
use App\Dtos\Doctor\ProfileRes;
use App\Dtos\Doctor\UpdateProfileReq;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    private DoctorRepository $doctorRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }
    
    public function profileDoctor($id){

        $doctor = $this->doctorRepository->getDoctorById($id);  
        
        return response()->json(
            [
            'message' => 'View profile doctor successfully',
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
            ]
        );
    }

    public function updateProfileDoctor(UpdateProfileReq $req)
    {
        $user = new User(
            Role::Doctor,
            $req->email,
            $req->password,
            $req->fullName,
            $req->phone,
            $req->address,
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
                $doctor->getId(),
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

    public function updateDoctor(User $user, Doctor $doctor, string $id)
    {
    $user_sql = "UPDATE users SET email = ?, password = ?, fullName = ?, phone = ?, address = ?, urlImage = ? WHERE id = ?";
    $doctor_sql = "UPDATE doctors SET description = ?, majorId = ? WHERE userId = ?";
    DB::update($user_sql, [
        $user->getEmail(),
        $user->getPassword(),
        $user->getFullName(),
        $user->getPhone(),
        $user->getAddress(),
        $user->getUrlImage(),
        $id
    ]);
    DB::update($doctor_sql, [
        $doctor->getDescription(),
        $doctor->getMajor(),
        $id
    ]);
    $newInformationUser = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);
    $newInformationDoctor = DB::selectOne("
        SELECT doctors.id, doctors.description, majors.name 
        FROM doctors
        INNER JOIN majors ON doctors.majorId = majors.id
        WHERE doctors.userId = ?", [$id]
    );

    return new Doctor(
        $newInformationDoctor->id,
        $newInformationDoctor->description,
        $newInformationDoctor->name,
        new User(
            Role::Doctor,
            $newInformationUser->email,
            $newInformationUser->fullName,
            $newInformationUser->phone,
            $newInformationUser->address,
            $newInformationUser->password,
            $newInformationUser->urlImage
        )
    );
    }
}
   