<?php

namespace App\Repositories;

use App\Dtos\Admin\DashboardStatsRes;
use App\Dtos\Admin\DoctorStatsRes;
use App\Dtos\Admin\MajorStatsRes;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminRepository
{
    public function getStats(): DashboardStatsRes
    {
        $totalUsers = DB::select("SELECT COUNT(*) AS totalUsers FROM users")[0]->totalUsers;
        $totalDoctors = DB::select("SELECT COUNT(*) AS totalDoctors FROM doctors")[0]->totalDoctors;
        $totalPatients = DB::select("SELECT COUNT(*) AS totalPatients FROM patients")[0]->totalPatients;
        $totalRevenue = DB::select("
            SELECT SUM(listtimedoctors.price) AS totalRevenue
            FROM appoinments
            JOIN calendars ON appoinments.calendarId = calendars.id
            JOIN listtimedoctors ON calendars.timeId = listtimedoctors.id
        ")[0]->totalRevenue;

        return new DashboardStatsRes(
            $totalUsers,
            $totalDoctors,
            $totalPatients,
            $totalRevenue
        );
    }

    public function getDoctors(): array
    {
        $results = DB::select("
            SELECT 
                users.fullName AS doctorName,
                users.urlImage AS avatar,
                users.email AS doctorEmail,
                majors.name AS doctorMajor,
                COUNT(appoinments.id) AS totalSlots,
                SUM(listtimedoctors.price) AS totalEarnings
            FROM doctors
            JOIN users ON doctors.userId = users.id
            JOIN majors ON doctors.majorId = majors.id
            LEFT JOIN appoinments ON doctors.id = appoinments.doctorId
            LEFT JOIN calendars ON appoinments.calendarId = calendars.id
            LEFT JOIN listtimedoctors ON calendars.timeId = listtimedoctors.id
            GROUP BY doctors.id, users.fullName, users.urlImage, users.email, majors.name
            ORDER BY totalSlots DESC
        LIMIT 10
        ");

        $doctors = [];
        foreach ($results as $result) {
            $doctors[] = new DoctorStatsRes(
                $result->doctorName,
                $result->avatar,
                $result->doctorEmail,
                $result->doctorMajor,
                $result->totalSlots,
                $result->totalEarnings
            );
        }

        return $doctors;
    }


    public function getMajors(): array
    {
        $results = DB::select("
            SELECT 
                majors.name AS majorName,
                COUNT(doctors.id) AS totalDoctors
            FROM majors
            JOIN doctors ON majors.id = doctors.majorId
            GROUP BY majors.id, majors.name
        ");

        $majors = [];
        foreach ($results as $result) {
            $majors[] = new MajorStatsRes(
                $result->majorName,
                $result->totalDoctors
            );
        }

        return $majors;
    }
}