<?php
namespace App\Dtos\Doctor;

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
    public string $image;
    public string $description;
    public string $majorId;

    public function __construct(Request $req)
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

        $this->id = $req->input("id");
        $this->email = $req->input("email");
        $this->password = $req->input("password");
        $this->fullName = $req->input("fullName");
        $this->address = $req->input("address");
        $this->phone = $req->input("phone");
        $this->image = $req->input("image");
        $this->description = $req->input("description");
        $this->majorId = $req->input("majorId");
    }
    public function rules(): array
    {
        return [
            'id' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'fullName' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|url',
            'description' => 'nullable',
            'majorId' =>'required'
        ];
    }
}