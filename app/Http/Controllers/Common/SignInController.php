<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Dtos\Common\SignInRes;
use App\Dtos\Common\SignInReq;
use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\Hash;

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

        if ($user === null || !Hash::check($req->password, $user->getPassword())) {
            return $this->unauthorized('User not found or invalid credentials');
        }

        if ($user->getStatus() === 0) {
            return $this->unauthorized('Account has been locked');
        }

        $patient = $this->patientRepository->findByEmail($req->email);

        return $this->success([
            'message' => 'Sign in Successfully',
            'payload' => new SignInRes(
                $patient->getUserId(),
                $user->getRole()->getValue(),
                $user->getEmail(),
                $user->getFullName(),
                $user->getPassword(),
                $user->getPhone(),
                $user->getAddress(),
                $user->getUrlImage()
            )
        ]);
    }

    protected function unauthorized($message)
    {
        return response()->json([
            'message' => $message,
        ], 401);
    }

    protected function success($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}