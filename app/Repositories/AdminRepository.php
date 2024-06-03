<?php

namespace App\Repositories;

use App\Dtos\Admin\DashboardStatsRes;
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
}