<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class CheckTimeReq
{
    public string $date;
    public string $doctorId;

    public function __construct(Request $req)
    {
        $this->date = $req->input("date");
        $this->doctorId = $req->input("doctorId");
    }
}