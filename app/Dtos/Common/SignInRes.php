<?php

namespace App\Dtos\Common;

class SignInRes
{
    public string $roleId;
    public string $role;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public string $image;


    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */
    public function __construct(string $roleId, string $role, string $email, string $fullName, string $password, string $address, string $phone, string $image)
    {
        $this->roleId = $roleId;
        $this->role = $role;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
    }
}