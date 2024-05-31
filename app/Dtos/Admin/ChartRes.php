<?php

namespace App\Dtos\Admin;
    class ChartRes
    {
        public string $doctorName;
        public string $totalCount;
    
    public function __construct(string $doctorName, string $totalCount)
    {
        $this->doctorName = $doctorName;
        $this->totalCount = $totalCount;
    }
}


