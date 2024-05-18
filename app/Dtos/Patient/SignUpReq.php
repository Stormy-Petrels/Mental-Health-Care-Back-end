<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="SignUpReq",
 *     title="Sign up Request",
 *     description="Request schema for sign up operation",
 *     required={"email", "fullName", "password", "phone", "address"}
 * )
 */
class SignUpReq
{
    /**
     * @OA\Property()
     * @var string
     */
    public string $email;

    /**
     * @OA\Property()
     * @var string
     */
    public string $fullName;

    /**
     * @OA\Property()
     * @var string
     */
    public string $password;

    /**
     * @OA\Property()
     * @var string
     */
    public string $phone;

    /**
     * @OA\Property()
     * @var string
     */
    public string $address;

    public function __construct(Request $req)
    {
        $this->email = $req->input("email");
        $this->fullName = $req->input("fullName");
        $this->password = $req->input("password");
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'fullName' => 'required',
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}
