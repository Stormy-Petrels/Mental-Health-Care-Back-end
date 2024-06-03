<?php

namespace App\Dtos\Admin;
class DoctorStatsRes
{
    public $doctorName;
    public $avatar;
    public $doctorEmail;
    public $doctorMajor;
    public $totalSlots;
    public $totalEarnings;
    public function __construct($doctorName, $avatar, $doctorEmail, $doctorMajor, $totalSlots, $totalEarnings)
    {
        $this->doctorName = $doctorName;
        $this->avatar = $avatar;
        $this->doctorEmail = $doctorEmail;
        $this->doctorMajor = $doctorMajor;
        $this->totalSlots = $totalSlots;
        $this->totalEarnings = $totalEarnings;
    }
}