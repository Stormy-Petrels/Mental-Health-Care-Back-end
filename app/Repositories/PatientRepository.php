<?php

namespace App\Repositories;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class PatientRepository
{
    private string $tableName = "patients";

    public function insert(Patient $patient)
    {
        $sql = "INSERT INTO $this->tableName (id, user_id) VALUES (?, ?)";
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
        return $newUser->id;
    }
    
    public function getInformationPatients()
    {
        $patients = DB::select("SELECT u.url_image, u.name, u.email, u.phone, u.address, p.health_condition, p.note, p.user_id
            FROM $this->tableName p
            JOIN users u ON p.user_id = u.id;");
    
        $patientList = [];
    
        foreach ($patients as $patient) {
            $user = new User(
                /* Cung cấp các thông tin cần thiết của User */
                $patient->role,
                $patient->email,
                $patient->fullName,
                $patient->phone,
                $patient->address,
                $patient->urlImage
            );
    
            $patientObj = new Patient(
                $patient->userid,
                $patient->healthCondition,
                $patient->note,
                $user
            );
    
            $patientList[] = $patientObj;
        }
    
        return json_encode($patientList);
    }
    
}