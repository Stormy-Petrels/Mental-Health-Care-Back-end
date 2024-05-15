<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class TimeRes
{
    public string $id;
    public string $timeStart;
    public string $timeEnd;
    public string $price;
    public string $calendarId;

    public function __construct(string $id, string $timeStart, string $timeEnd, string $price, string $calendarId)
    {
        $this->id = $id;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->price = $price;
        $this->calendarId = $calendarId;
    }
}