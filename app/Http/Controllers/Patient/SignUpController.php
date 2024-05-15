<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Dtos\Common\SignInRes;
use App\Dtos\Patient\SignUpReq;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Repositories\PatientRepository;
use App\Repositories\UserRepository;
use OpenApi\Annotations as OA;

class SignUpController extends Controller
{
    private UserRepository $userRepository;
    private PatientRepository $patientRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->patientRepository = new PatientRepository();
    }
    public function index()
    {
        return view("patients\signUp");
    }

/**
     * @OA\Post(
     *      path="/api/patient/signup",
     *      operationId="signup",
     *      tags={"Patient"},
     *      summary="Patient SignUp",
     *      description="Register a new Patient",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "fullName", "password", "phone", "address"},
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="fullName", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="address", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *          @OA\JsonContent(ref="#/components/schemas/SignInRes")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Email already exists",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Email already exists"),
     *              @OA\Property(property="error", type="string", example="email is error")
     *          )
     *      )
     * )
     */
    public function signUp(SignUpReq $req)
    {
        $user = $this->userRepository->findByEmail($req->email);
        if ($user != null) {
            return response()->json([
                "message" => "email already exists",
                "error" => "email is error"
            ], 401);
        }
        $newUser = new User(Role::Patient, $req->email, $req->password, $req->fullName, $req->phone, $req->address);
        $newPatient = new Patient($newUser->getId());

        $this->userRepository->insert($newUser);
        $this->patientRepository->insert($newPatient);

        return response()->json([
            'message' => 'Sign Up Successfully',
            'payload' => new SignInRes(
                $newUser->getId(),
                $newUser->getRole()->getValue(),
                $newUser->getEmail(),
                $newUser->getFullname(),
                $newUser->getPassword(),
                $newUser->getPhone(),
                $newUser->getAddress(),
                $newUser->getUrlImage()
            )
        ], 200);
    }
}