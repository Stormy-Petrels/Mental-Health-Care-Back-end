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
        $this->email = $request->input("email");
        $this->password = $request->input("password");

        $this->validateInput();
    }

    protected function validateInput(): void
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            $response = response()->json([
                'errors' => $validator->errors()
            ], 422);
            $response->throwResponse();
        }
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}