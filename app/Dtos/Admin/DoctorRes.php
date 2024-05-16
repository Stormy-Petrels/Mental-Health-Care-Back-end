<?php

namespace App\Dtos\Admin;

class DoctorRes
{
    public string $id;
    public string $description;
    public string $major;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public string $image;
    public string $isActive;
    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */

    public function __construct(string $id,string $description,string $major, string $email, string $fullName, string $password, string $address, string $phone, string $image, string $isActive)
    {
        $this->id = $id;
        $this->description = $description;
        $this->major = $major;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
        $this->isActive = $isActive;
    }
}