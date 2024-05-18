<?php

namespace App\Dtos\Patient;

/**
 * @OA\Schema(
 *     schema="ProfileResPatient",
 *     type="object",
 *     title="ProfileRes",
 *     description="Profile Response DTO",
 *     @OA\Property(property="id", type="string", description="Doctor ID"),
 *     @OA\Property(property="email", type="string", description="Doctor Email"),
 *     @OA\Property(property="password", type="string", description="Doctor Password"),
 *     @OA\Property(property="fullName", type="string", description="Doctor Full Name"),
 *     @OA\Property(property="address", type="string", description="Doctor Address"),
 *     @OA\Property(property="phone", type="string", description="Doctor Phone"),
 *     @OA\Property(property="image", type="string", description="Doctor Image URL"),
 *     @OA\Property(property="healthCondition", type="string", description="Patient healthCondition"),
 *     @OA\Property(property="note", type="string", description="Patient Major"),
 * )
*/
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
    public function __construct(string $id, string $email, string $password, string $fullName, string $address, string $phone, string $image, string $healthCondition, string $note)
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