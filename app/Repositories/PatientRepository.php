<?php


namespace App\Repositories;


use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;




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

    public function findByEmail(string $email): Patient
    {
        $result = DB::select(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$email]
        );

        if (empty($result)) {
            return null;
        }

        $userData = $result[0];
        return new Patient($userData->id);
    }

    public function getInformationPatients()
    {
        $results = DB::select("SELECT u.email, u.password, u.fullName, u.address, u.phone, u.urlImage,u.isActive, p.healthCondition, p.note, p.userId as patientId
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
                    $result->urlImage,
                    $result->isActive
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
            hash::make($user->getPassword()),
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
        $newInformationPatient = DB::selectOne(
            "
            SELECT patients.id, patients.healthCondition, patients.note
            FROM patients
            WHERE patients.userId = ?",
            [$id]
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


    public function createPatient($user, $patient)
    {
        $insertUser = "INSERT INTO users (id, role, fullName, email, password, phone, address, urlImage, isActive, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($insertUser, [
            $user->getId(),
            $user->getRole()->getValue(),
            $user->getFullname(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getAddress(),
            $user->getUrlImage(),
            $user->getStatus(),
            Carbon::now(),
            Carbon::now()
        ]);


        $insertPatient = "INSERT INTO patients (id, userId, healthCondition, note, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?);";
        DB::insert($insertPatient, [
            $user->getId(),
            $user->getId(),
            $patient->getHealthCondition(),
            $patient->getNote(),
            Carbon::now(),
            Carbon::now()
        ]);


        $sql = "SELECT * FROM users JOIN patients ON users.id = patients.userId WHERE users.id = ?";
        $newPatient = DB::select($sql, [$user->getId()]);


       
        return new
            Patient(
                $newPatient[0]->id,
                $newPatient[0]->healthCondition,
                $newPatient[0]->note,
                new User(
                    Role::Patient,
                    $newPatient[0]->email,
                    $newPatient[0]->password,
                    $newPatient[0]->fullName,
                    $newPatient[0]->address,
                    $newPatient[0]->phone,
                    $newPatient[0]->urlImage,
                    $newPatient[0]->isActive
                )
            );
    }
}
