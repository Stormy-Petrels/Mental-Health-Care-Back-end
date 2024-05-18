<?php

namespace App\Dtos\Common;

use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *     schema="SignInReqCommon",
 *     type="object",
 *     title="SignInReq",
 *     description="Request object for user sign-in",
 *     required={"email", "password"}
 * )
 */
class SignInReq
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
    public string $password;

    public function __construct(Request $request)
    {
        $this->email = $request->input("email");
        $this->password = $request->input("password");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}
