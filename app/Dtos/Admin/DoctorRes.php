<?php

namespace App\Dtos\Admin;

/**
 * @OA\Schema(
 *     schema="DoctorRes",
 *     type="object",
 *     title="DoctorRes",
 *     description="Response object for ",
 *     required={"id", "description", "major", "email", "password", "fullName", "address", "phone", "image", "isActive"}
 * )
 */
class DoctorRes
{
    /**
     * @OA\Property()
     * @var string
     */
    public string $id;
    /**
     * @OA\Property()
     * @var string
     */
    public string $description;
    /**
     * @OA\Property()
     * @var string
     */
    public string $major;
    /**
     * @OA\Property()
     * @var string
     */
    public string $email;
    /**
     * @OA\Property()
     * @var string
     */
    public string $password;
    /**
     * @OA\Property()
     * @var string
     */
    public string $fullName;
    /**
     * @OA\Property()
     * @var string
     */
    public string $address;
    /**
     * @OA\Property()
     * @var string
     */
    public string $phone;
    /**
     * @OA\Property()
     * @var string
     */
    public string $image;
    /**
     * @OA\Property()
     * @var string
     */
    public string $isActive;
    /**
     * @OA\Property()
     * @var string
     */

    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */

    public function __construct(string $id, string $description, string $major, string $email, string $password, string $fullName, string $address, string $phone, string $image, string $isActive)
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
        $this->isActive = $isActive;
    }
}
