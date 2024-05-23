<?php

namespace App\Models;

class Major                          
{
    public string $id;
    public string $name;


    /**
     * @param string $userid
     * @throws \Exception
     */
    
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getId(): string
    {
        return $this->id;
    }

    public function getTimeStart(): string
    {
        return $this->name;
    }
}