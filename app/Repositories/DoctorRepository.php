<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Time;
use Carbon\Carbon;

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
        $query = DB::select("SELECT users.id AS user_id, users.role, users.email, users.password, users.fullName, users.address, users.phone, users.urlImage,doctors.id, doctors.description, doctors.majorId, majors.name
        FROM users
        JOIN doctors ON users.id = doctors.userId
        JOIN majors ON doctors.majorId = majors.id
        WHERE users.role = 'doctor' AND doctors.id = '$id'");
        $result = $query[0];
        return new Doctor($result->id, $result->description, $result->name, new User(Role::Doctor, $result->email, $result->password, $result->fullName, $result->address, $result->phone, $result->urlImage));
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
                    $result->password,
                    $result->fullName,
                    $result->address,
                    $result->phone,
                    $result->urlImage,
                    $result->isActive,
                )
            );

            $doctors[] = $doctor;
        }

        return $doctors;
    }

    public function getAvailableTimesForBooking($selectedDate, $Doctorid)
    {
        $query = "SELECT lt.*,c.id
        FROM calendars AS c
        JOIN listTimeDoctors AS lt ON c.timeId = lt.id
        WHERE c.doctorId = '$Doctorid' AND c.date = '$selectedDate'
          AND NOT EXISTS (
            SELECT 1
            FROM appoinments AS a
            WHERE a.calendarId = c.id
          );";
        $result = DB::select($query);
        $collection = collect($result);
        $times = $collection->map(function ($time) {
            return new Time(
                $time->id,
                $time->timeStart,
                $time->timeEnd,
                $time->price,
                $time->id
            );
        });
        return $times;
    }
    public function updateDoctor(User $user, Doctor $doctor, string $id)
    {
        $user_sql = "UPDATE users SET email = ?, password = ?, fullName = ?, address = ?, phone = ?, urlImage = ? WHERE id = ?";
        $doctor_sql = "UPDATE doctors SET description = ?, majorId = ? WHERE userId = ?";
        DB::update($user_sql, [
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $id
        ]);
        DB::update($doctor_sql, [
            $doctor->getDescription(),
            $doctor->getMajor(),
            $id
        ]);
        $newInformationUser = DB::selectOne("SELECT * FROM users WHERE id = ?", [$id]);
        $newInformationDoctor = DB::selectOne(
            "
            SELECT doctors.id, doctors.description, majors.name 
            FROM doctors
            INNER JOIN majors ON doctors.majorId = majors.id
            WHERE doctors.userId = ?",
            [$id]
        );

        return new Doctor(
            $newInformationDoctor->id,
            $newInformationDoctor->description,
            $newInformationDoctor->name,
            new User(
                Role::Doctor,
                $newInformationUser->email,
                $newInformationUser->password,
                $newInformationUser->fullName,
                $newInformationUser->address,
                $newInformationUser->phone,
                $newInformationUser->urlImage
            )
        );
    }

    public function createDoctor($user, $doctor)
    {
        $sql = "INSERT INTO users (id, role, fullName, email, password, phone, address, urlImage, isActive, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
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
        return new Doctor($newUserResult[0]->id, $newUserResult[0]->description, $newUserResult[0]->majorId, new User(Role::Doctor, $newUserResult[0]->email, $newUserResult[0]->password, $newUserResult[0]->fullName, $newUserResult[0]->address, $newUserResult[0]->phone, $newUserResult[0]->urlImage, $newUserResult[0]->isActive));
    }
}
