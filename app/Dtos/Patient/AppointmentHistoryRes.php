<?php

namespace App\Dtos\Patient;

class AppointmentHistoryRes
{
    public string $appointmentId;
    public string $patientName;
    public string $doctorName;
    public string $image;
    public string $price;
    public string $date;
    public string $timeStart;
    public string $timeEnd;
    public string $status;

    public function __construct(string $appointmentId, string $patientName, string $doctorName, string $image, string $price, string $date, string $timeStart, string $timeEnd, string $status)
    {
        $this->appointmentId = $appointmentId;
        $this->patientName = $patientName;
        $this->doctorName = $doctorName;
        $this->image = $image;
        $this->price = $price;
        $this->date = $date;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->status = $status;
    }
}