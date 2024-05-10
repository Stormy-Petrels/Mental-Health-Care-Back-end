<?php
namespace App\Dtos\Doctor;

use Illuminate\Http\Request;
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
        $this->id = $req->id;
        $this->email =$req->email;
        $this->password = $req->password;
        $this->fullName = $req->fullName;
        $this->address = $req->address;
        $this->phone = $req->phone;
        $this->image = $req->image;
        $this->description = $req->description;
        $this->majorId = $req->majorId;
    }
    public function rules(): array
    {
        return [
            'id' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'fullName' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'nullable|url',
            'description' => 'nullable',
            'majorId' =>'required'
        ];
    }
}