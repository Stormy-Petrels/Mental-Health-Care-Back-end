<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel                          
{
    public string $userid;
    public string|null $major;
    public string|null $description;
    public User|null $user;
    /**
     * @param string $userid
     * @throws \Exception
     */
    
    public function __construct(string $userid, string $major, string $description, User|null $user=null)
    {
        parent::__construct();
        $this->userid = $userid;
        $this->major = $major;
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
    public function getMajor(): string
    {
        return $this->major;
    }
}