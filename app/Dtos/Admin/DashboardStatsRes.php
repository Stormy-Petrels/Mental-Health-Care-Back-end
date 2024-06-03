<?php

namespace App\Dtos\Admin;
class DashboardStatsRes
{
     public string $totalUsers;
     public string $totalDoctors;
     public string $totalPatients;
     public string $totalRevenue;
     public function __construct(string $totalUsers, string $totalDoctors, string $totalPatients, string $totalRevenue)
     {
         $this->totalUsers = $totalUsers;
         $this->totalDoctors = $totalDoctors;
         $this->totalPatients = $totalPatients;
         $this->totalRevenue = $totalRevenue;
     }

    
    
}