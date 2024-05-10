<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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

    public function getInformationPatients()
    {
        $results = DB::select("SELECT u.email, u.password, u.fullName, u.address, u.phone, u.urlImage, p.healthCondition, p.note, p.userId as patientId
            FROM $this->tableName p
            JOIN users u ON p.userId = u.id;");

        $patients = [];

        foreach ($results as $result) {
            $patient = new Patient(
                $result->patientId,
                $result->healthCondition,
                $result->note,
                new User(
                    Role::Patient,
                    $result->email,
                    $result->password,
                    $result->fullName,
                    $result->address,
                    $result->phone,
                    $result->urlImage
                )
            );
            $patients[] = $patient;
        }

        return $patients;
    }
    
    public function getPatientById($id)
    {
        $query = DB::select("SELECT users.id AS user_id, users.role, users.email, users.password, users.fullName, users.address, users.phone, users.urlImage, patients.id, patients.healthCondition, patients.note
        FROM users
        JOIN patients ON users.id = patients.userId
        WHERE users.role = 'patient' AND patients.id = '$id'");
        $result = $query[0];
        return new Patient(
            $result->id,
            $result->healthCondition,
            $result->note,
            new User(Role::Patient, $result->email, $result->password, $result->fullName, $result->address, $result->phone, $result->urlImage)
        );
    }

    public function updatePatient(User $user, Patient $patient, string $id)
    {
        $user_sql = "UPDATE users SET email = ?, password = ?, fullName = ?, address = ?, phone = ?, urlImage = ? WHERE id = ?";
        $patient_sql = "UPDATE patients SET healthCondition = ?, note = ? WHERE userId = ?";
  
        DB::update($user_sql, [
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $id
        ]);
        DB::update($patient_sql, [
            $patient->getHealthCondition(),
            $patient->getNote(),
            $id
        ]);

        $newInformationUser = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);
        $newInformationPatient = DB::selectOne("
            SELECT patients.id, patients.healthCondition, patients.note
            FROM patients
            WHERE patients.userId = ?", [$id]
        );

        return new Patient(
            $newInformationPatient->id,
            $newInformationPatient->healthCondition,
            $newInformationPatient->note,
            new User(
                Role::Patient,
                $newInformationUser->email,
                $newInformationUser->password,
                $newInformationUser->fullName,
                $newInformationUser->address,
                $newInformationUser->phone,
                $newInformationUser->urlImage
            )
        );
    }
}