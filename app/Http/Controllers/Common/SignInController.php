<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Dtos\Common\SignInRes;
use App\Dtos\Common\SignInReq;
use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;

class SignInController extends Controller
{
    private PatientRepository $patientRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->patientRepository = new PatientRepository();
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        return view("common\SignIn");
    }
/**
     * @OA\Post(
     *     path="/api/sign-in",
     *     summary="Sign in a user",
     *     tags={"Common"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SignInReqCommon")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sign in Successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="payload", ref="#/components/schemas/SignInResCommon")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="User not found or invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function signIn(SignInReq $req)
    {
        $user = $this->userRepository->findByEmail($req->email);

        if ($user == "" || $user->getPassword() != $req->password) {
            return response()->json([
                'message' => 'User not found or invalid credentials',
            ], 401);
        }
        $patient = $this->patientRepository->findByEmail($req->email);
        return response()->json([
            'message' => 'Sign in Successfully',
            'payload' => new SignInRes(
                $patient->getUserId(),
                $user->getId(),
                $user->getRole()->getValue(),
                $user->getEmail(),
                $user->getFullName(),
                $user->getPassword(),
                $user->getPhone(),
                $user->getAddress(),
                $user->getUrlImage()
            )
        ],200);
    }
}