<?php

namespace App\Dtos\Doctor;
use App\Repositories\DoctorRepository; 
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateProfileReq
{
    public string $id;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public ?string $image;
    public string $description;
    public string $majorId;

    public function __construct(Request $req, DoctorRepository $doctorRepository)
    {
        $data = [
            'id' => $req->input("id"),
            'email' => $req->input("email"),
            'password' => $req->input("password"),
            'fullName' => $req->input("fullName"),
            'address' => $req->input("address"),
            'phone' => $req->input("phone"),
            'image' => $req->input("image"),
            'description' => $req->input("description"),
            'majorId' => $req->input("majorId")
        ];

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400)->throwResponse();
        }

     
        if (!isset($data['image']) || $data['image'] === '') {
            $doctor = $doctorRepository->getDoctorById($data['id']);
            $this->image = $doctor->user->getUrlImage();
        } else {
            $this->image = $data['image'];
        }

        // Assign other properties as before
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->fullName = $data['fullName'];
        $this->address = $data['address'];
        $this->phone = $data['phone'];
        $this->description = $data['description'];
        $this->majorId = $data['majorId'];
    }

    public function rules(): array
    {
        return [
            'id' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'fullName' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
            'majorId' => 'required'
        ];
    }
}