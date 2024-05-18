<?php

namespace App\Dtos\Doctor;

/**
 * @OA\Schema(
 *     schema="ProfileRes",
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
 *     @OA\Property(property="description", type="string", description="Doctor Description"),
 *     @OA\Property(property="major", type="string", description="Doctor Major"),
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
    public string $description;
    public string $major;

    /**
     * @param string $id
     * @param string $email
     * @param string $password
     * @param string $fullName
     * @param string $address
     * @param string $phone
     * @param string $image
     * @param string $description
     * @param string $major
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
