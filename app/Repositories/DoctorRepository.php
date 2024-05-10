<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Time;

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
}