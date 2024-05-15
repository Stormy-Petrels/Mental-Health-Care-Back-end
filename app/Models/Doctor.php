<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends BaseModel                          
{
    public string $userId;
    public string $description;
    public string|null $major;
    public User|null $user;

    /**
     * @param string $userId
     * @throws \Exception
     */
    
    public function __construct(string $userId, string $description,string|null $major = null, User|null $user = null)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->description = $description;
        $this->major = $major;
        $this->user = $user;
    }
    
    public function getUserId(): string
    {
        return $this->userId;
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