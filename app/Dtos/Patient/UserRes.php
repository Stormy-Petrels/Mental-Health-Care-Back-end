<?php

namespace App\Dtos\Patient;


class UserRes
{
    public string $id;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public ?string $image;
  
    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */
    public function __construct(string $id, string $email, string $password, string $fullName, string $address, string $phone, string $image)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
    }
}