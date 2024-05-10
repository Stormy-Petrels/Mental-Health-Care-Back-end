<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class AppoinmentReq
{
    public string $date;
    public string $patientId;
    public string $doctorId;
    public string $CalendarId;

    public function __construct(Request $req)
    {
        $this->date = $req->input("date");
        $this->patientId = $req->input("patientId");
        $this->doctorId = $req->input("doctorId");
        $this->CalendarId = $req->input("calendarId");
    }
}