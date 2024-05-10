<?php

namespace App\Models;

class Time                          
{
    public string $id;
    public string $timeStart;
    public string $timeEnd;
    public string $price;
    public string $calendarId;


    /**
     * @param string $userid
     * @throws \Exception
     */
    
    public function __construct(string $id, string $timeStart,string $timeEnd,string $price, string $calendarId)
    {
        $this->id = $id;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->price = $price;
        $this->calendarId = $calendarId;
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getTimeStart(): string
    {
        return $this->timeStart;
    }
    
    public function getTimeEnd(): string
    {
        return $this->timeEnd;
    }

    public function getCalendarId(): string
    {
        return $this->calendarId;
    }
}