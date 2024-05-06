<?php
namespace App\Dtos\Patient;

class ProfileRes
{
    public string $id;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public string $image;
    public string $healthCondition;
    public string $note;

    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */
    public function __construct(string $id, string $email, string $fullName, string $password, string $address, string $phone, string $image, string $healthCondition, string $note)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
        $this->healthCondition = $healthCondition;
        $this->note = $note;
    }
}