<?php

namespace App\Dtos\Patient;
/**
 * @OA\Schema(
 *     schema="ViewInformationDoctorRes",
 *     title="View Information Doctor Response",
 *     required={"id", "description", "major", "email", "password", "fullName", "address", "phone", "image"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="ID of the doctor"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the doctor"
 *     ),
 *     @OA\Property(
 *         property="major",
 *         type="string",
 *         description="Major of the doctor"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the doctor"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password of the doctor"
 *     ),
 *     @OA\Property(
 *         property="fullName",
 *         type="string",
 *         description="Full name of the doctor"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Address of the doctor"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         description="Phone number of the doctor"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string",
 *         description="URL of the doctor's image"
 *     )
 * )
 */
class ViewInformationDoctorRes
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