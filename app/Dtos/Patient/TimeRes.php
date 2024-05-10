<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class TimeRes
{
    public string $id;
    public string $timeStart;
    public string $timeEnd;
    public string $price;

    public function __construct(string $id, string $timeStart, string $timeEnd, string $price)
    {
        $this->id = $id;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->price = $price;
    }
}