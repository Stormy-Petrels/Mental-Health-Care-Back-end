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

    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */

    public function __construct(string $id,string $description,string $major, string $email, string $fullName, string $password, string $address, string $phone, string $image)
    {
        $this->id = $id;
        $this->description = $description;
        $this->major = $major;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
    }
}