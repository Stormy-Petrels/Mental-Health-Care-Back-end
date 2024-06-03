<?php
namespace App\Dtos\Admin;
class MajorStatsRes
{
    public $majorName;
    public $totalDoctors;

    public function __construct($majorName, $totalDoctors)
    {
        $this->majorName = $majorName;
        $this->totalDoctors = $totalDoctors;
    }
}