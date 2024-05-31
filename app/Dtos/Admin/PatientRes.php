<?php


namespace App\Dtos\Admin;


class PatientRes
{
    public string $id;
    public string $healthCondition;
    public string $note;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public string $image;
    public string|null $isActive;
   
    public function __construct(string $id, string $healthCondition, string $note, string $email, string $password, string $fullName, string $address, string $phone, string $image, string|null $isActive = null){
        $this->id = $id;
        $this->healthCondition = $healthCondition;
        $this->note = $note;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
        $this->isActive = $isActive;
    }
   
}
