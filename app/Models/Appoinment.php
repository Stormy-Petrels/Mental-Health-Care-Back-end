<?php

namespace App\Models;

class Appoinment extends BaseModel
{
    public string $date;
    public string $patientId;
    public string $doctorId;
    public string $timeId;

    /**
     * @param string $userid
     */
    public function __construct(string $patientId, string $doctorId,  string $date, string $id)
    {
        parent::__construct();
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->date = $date;
        $this->timeId = $id;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getDocterId(): string
    {
        return $this->doctorId;
    }

    public function getTimeId(): string
    {
        return $this->timeId;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}