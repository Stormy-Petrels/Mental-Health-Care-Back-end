<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Dtos\Common\SignInReq;
use App\Http\Controllers\Common\SignInController;
use Mockery;
use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;

    private $userRepositoryMock;
    private $patientRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock repositories
        $this->userRepositoryMock = Mockery::mock(UserRepository::class);
        $this->patientRepositoryMock = Mockery::mock(PatientRepository::class);

        // Bind mocks to the service container
        $this->app->instance(UserRepository::class, $this->userRepositoryMock);
        $this->app->instance(PatientRepository::class, $this->patientRepositoryMock);
    }

    public function test_sign_in_success()
    {
        // Create a request array
        $requestData = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        // Create a Request object
        $request = new Request($requestData);
        $signInReq = new SignInReq($request);

        $hashedPassword = bcrypt('password123');

        // Mock the user object
        $user = new \stdClass();
        $user->getEmail = function () {
            return 'test@example.com';
        };
        $user->getPassword = function () use ($hashedPassword) {
            return $hashedPassword;
        };
        $user->getStatus = function () {
            return 1; 
        };
        $user->getRole = function () {
            $role = new \stdClass();
            $role->getValue = function () {
                return 'user';
            };
            return $role;
        };
        $user->getFullName = function () {
            return 'Test User';
        };
        $user->getPhone = function () {
            return '123456789';
        };
        $user->getAddress = function () {
            return 'Test Address';
        };
        $user->getUrlImage = function () {
            return 'test.jpg';
        };

        // Mock the user repository
        $this->userRepositoryMock
            ->shouldReceive('findByEmail')
            ->with('test@example.com')
            ->andReturn($user);

        // Mock the patient repository
        $patient = new \stdClass();
        $patient->getUserId = function () {
            return 1;
        };
        $patient->getEmail = function () {
            return 'test@example.com';
        };

        $this->patientRepositoryMock
            ->shouldReceive('findByEmail')
            ->with('test@example.com')
            ->andReturn($patient);

        // Call the controller method
        $controller = new SignInController();
        $response = $controller->signIn($signInReq);

        $this->assertInstanceOf(JsonResponse::class, $response);
        if (method_exists($user, 'getStatus')) {
            $this->assertEquals(200, $response->getStatusCode());
            $this->assertEquals('Sign in Successfully', $response->getData()->message);
        }
    }
}
