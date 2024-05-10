<?php

namespace App\Repositories;

use App\Dtos\Admin\DoctorReq;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
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

    public function createDoctor($user, $doctor)
    {
        $sql = "INSERT INTO users (id, role, fullName, email, password, phone, address, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $user->getId(),
            $user->getRole()->getValue(),
            $user->getFullname(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getAddress(),
            Carbon::now(),
            Carbon::now()
        ]);

        $sqlInsertDoctor = "INSERT INTO doctors (id, userId, description, majorId, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?);";
        DB::insert($sqlInsertDoctor, [
            $user->getId(),
            $user->getId(),
            $doctor->getDescription(),
            $doctor->getMajor(),
            Carbon::now(),
            Carbon::now()
        ]);

        $sql = "SELECT * FROM users JOIN doctors ON users.id = doctors.userId WHERE users.id = ?";
        $newUserResult = DB::select($sql, [$user->getId()]);
        return new Doctor($newUserResult[0]->id, $newUserResult[0]->description, $newUserResult[0]->majorId, new User (Role::Doctor, $newUserResult[0]->email, $newUserResult[0]->password, $newUserResult[0]->fullName, $newUserResult[0]->phone, $newUserResult[0]->address, $newUserResult[0]->urlImage));
    }
}
