<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel                          
{
    public string $userid;
    public string $specialization;
    public string $description;
    /**
     * @param string $userid
     * @throws \Exception
     */
    
    public function __construct(string $userid, string $specialization, string $description)
    {
        parent::__construct();
        $this->userid = $userid;
        $this->specialization = $specialization;
        $this->description = $description;
    }
    public function getUserId(): string
    {
        return $this->userid;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getSpecialization(): string
    {
        return $this->specialization;
    }
}