<?php

namespace App\Dtos\Admin;
    class AppointmentRes
    {
        public string $appointmentId;
        public string $patientName;
        public string $doctorName;
        public string $date;
        public string $timeStart;
        public string $timeEnd;
    
    public function __construct(string $appointmentId, string $patientName, string $doctorName, string $date, string $timeStart, string $timeEnd)
    {
        $this->appointmentId = $appointmentId;
        $this->patientName = $patientName;
        $this->doctorName = $doctorName;
        $this->date = $date;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
    }
}


