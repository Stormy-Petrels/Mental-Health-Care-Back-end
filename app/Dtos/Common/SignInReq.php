<?php

namespace App\Dtos\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $data = [
            'email' => $request->input("email"),
            'password' => $request->input("password"),
        ];
    
        $validator = Validator::make($data, $this->rules());
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422)->throwResponse();
        }
        $this->email = $request->input("email");
        $this->password = $request->input("password");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }
}
