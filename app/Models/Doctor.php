<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel                          
{
    public string $userid;
    public string $description;
    public string|null $major;
    public User|null $user;

    /**
     * @param string $userid
     * @throws \Exception
     */
    
    public function __construct(string $userid, string $description,string|null $major = null, User|null $user = null)
    {
        parent::__construct();
        $this->userid = $userid;
        $this->description = $description;
        $this->major = $major;
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
    
    public function getMajor(): string
    {
        return $this->major;
    }
}