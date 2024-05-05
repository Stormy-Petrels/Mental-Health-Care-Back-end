<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel
{
    public string $userid;
    public string $specialization;
    public string $description;
    public User|null $user;
    /**
     * @param string $userid
     * @throws \Exception
     */
    public function __construct(string $userid, string $specialization, string $description, User|null $user)
    {
        parent::__construct();
        $this->userid = $userid;
        $this->specialization = $specialization;
        $this->description = $description;
        $this->user = $user;
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