<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class PatientRepository
{
    private string $tableName = "patients";

    public function insert(Patient $patient)
    {
        $sql = "INSERT INTO $this->tableName (id, userId) VALUES (?, ?)";
        DB::insert($sql, [
            $patient->getId(),
            $patient->getId()
        ]);
    }

    public function findByEmail($email)
    {
        $result = DB::select("SELECT * FROM users
        WHERE email = ? LIMIT 1", [$email]);
        $newUser = $result[0];
        return new Patient($newUser->id);
    }
    public function getPatientById($id)
    {
        $query = DB::select("SELECT users.id AS user_id, users.role, users.email, users.fullName, users.phone, users.address, users.password, users.urlImage,patients.id, patients.healthCondition, patients.note
        FROM users
        JOIN patients ON users.id = patients.userId
        WHERE users.role = 'patient' AND patients.id = '$id'");
        $result = $query[0];
        return new Patient(
            $result->id,
            $result->healthCondition,
            $result->note,
            new User(Role::Patient, $result->email, $result->password, $result->fullName, $result->phone, $result->address, $result->urlImage)
        );
    }

    public function updatePatient(User $user, Patient $patient)
    {
        $user_sql = "UPDATE users SET name = ?, password = ?, phone = ?, address = ? WHERE id = ?";
        $patient_sql = "UPDATE patients SET healthCondition = ?, note = ?  WHERE userId = ?";

        $user = DB::update($user_sql, [
            $user->getFullName(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getAddress(),
            $patient->getUserId()
        ]);

        $patient = DB::update($patient_sql, [
            $patient->getHealthCondition(),
            $patient->getNote(),
            $patient->getUserId()
        ]);

        return $patient;
    }
    public function getDoctorById(string $id)
    {
        $query = DB::select("SELECT users.id AS userId, users.role, users.email, users.fullName, users.phone, users.address, users.password, users.urlImage,doctors.id, doctors.description, doctors.majorId, majors.name
        FROM users
        JOIN doctors ON users.id = doctors.userId
        JOIN majors ON doctors.majorId = majors.id
        WHERE users.role = 'doctor' AND doctors.id = '$id'");
        $result = $query[0];
        return new Doctor($result->id, $result->description, $result->name, new User(Role::Doctor, $result->email, $result->password, $result->fullName, $result->phone, $result->address, $result->urlImage));
    }
}
