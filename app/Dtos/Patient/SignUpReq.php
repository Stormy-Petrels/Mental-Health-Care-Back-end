<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $data = [
            'email' => $req->input("email"),
            'fullName' => $req->input("fullName"),
            'password' => $req->input("password"),
            'phone' => $req->input("phone"),
            'address' => $req->input("address"),
        ];
    
        $validator = Validator::make($data, $this->rules());
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422)->throwResponse();
        }

        $this->email = $req->input("email");
        $this->fullName = $req->input("fullName");
        $this->password = Hash::make($req->input("password"));
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'fullName' => 'required',
            'password' => 'required|min:8',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}
