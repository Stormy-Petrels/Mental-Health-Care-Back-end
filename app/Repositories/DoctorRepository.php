<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

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
        return new doctor($result->id, $result->description, $result->name, new User(Role::Doctor,$result->email,$result->password,$result->fullName,$result->phone,$result->address,$result->urlImage));
    }

}
