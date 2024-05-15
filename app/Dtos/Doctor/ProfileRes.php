<?php

namespace App\Dtos\Doctor;

class ProfileRes
{
    public string $id;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public string $image;
    public string $description;
    public string $major;

    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */
    public function __construct(string $id, string $email, string $password, string $fullName, string $address, string $phone, string $image, string $description, string $major)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
        $this->description = $description;
        $this->major = $major;
    }
}