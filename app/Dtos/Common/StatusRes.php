<?php

namespace App\Dtos\Common;

use App\Models\Role;

class StatusRes
{
    public string $role;
    public string $email;
    public string $fullName;
    public string $isActive;

    /**
     * @param string $role
     * @param string $email
     * @param string $fullName
     * @param string $isActive
     */

    public function __construct(string $role, string $email, string $fullName, string $isActive)
    {
        $this->role = $role;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->isActive = $isActive;
    }
}