<?php

namespace App\Models;

class Patient extends BaseModel
{

    public string $userid;
    public string|null $healthCondition;
    public string|null $note;
    public User|null $user;

    /**
     * @param string $userid
     */
    public function __construct(string $userid, string|null $healthCondition = null, string|null $note = null, User|null $user = null)
    {
        parent::__construct();
        $this->userid = $userid;
        $this->healthCondition = $healthCondition;
        $this->note = $note;
        $this->user = $user;
    }

    public function getUserId(): string
    {
        return $this->userid;
    }

    public function getHealthCondition(): string|null
    {
        return $this->healthCondition == null ? " " : $this->healthCondition;
    }
    public function getNote(): string|null
    {
        return $this->note == null ? " " : $this->note;
    }
}