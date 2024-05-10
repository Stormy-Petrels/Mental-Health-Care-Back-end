<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DoctorRepository
{
    private $tableName = "doctors";

    public function findById($id)
    {
        $result = DB::select("SELECT * FROM $this->tableName WHERE id = ?", [$id]);
        $doctor = $result[0];
        return new Doctor(
            $doctor->userId,
            $doctor->majorId,
            $doctor->description
        );
    }

    public function getDoctorById(string $id)
    {
        $query = DB::select("SELECT users.id AS user_id, users.role, users.email, users.fullName, users.phone, users.address, users.password, users.urlImage,doctors.id, doctors.description, doctors.majorId, majors.name
        FROM users
        JOIN doctors ON users.id = doctors.userId
        JOIN majors ON doctors.majorId = majors.id
        WHERE users.role = 'doctor' AND doctors.id = '$id'");
        $result = $query[0];
        return new Doctor($result->id, $result->description, $result->name, new User(Role::Doctor, $result->email, $result->password, $result->fullName, $result->phone, $result->address, $result->urlImage));
    }

    public function queryAllDoctors()
    {
        $results = DB::select("
            SELECT users.*, doctors.id AS doctor_id, doctors.description, doctors.majorId, majors.name AS majorName
            FROM users
            JOIN doctors ON users.id = doctors.userId
            JOIN majors ON doctors.majorId = majors.id
            WHERE users.role = 'doctor'
        ");
    
        $doctors = [];
    
        foreach ($results as $result) {
            $doctor = new Doctor(
                $result->doctor_id,
                $result->description,
                $result->majorName,
                new User(
                    Role::Doctor,
                    $result->email,
                    $result->fullName,
                    $result->phone,
                    $result->address,
                    $result->password,
                    $result->urlImage
                )
            );
    
            $doctors[] = $doctor;
        }
    
        return $doctors;
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