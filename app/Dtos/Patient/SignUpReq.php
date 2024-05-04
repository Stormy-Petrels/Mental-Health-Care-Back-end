<?php
namespace App\Dtos\Patient;
use Illuminate\Http\Request;

class SignUpReq
{
    public string $email;
    public string $fullName;
    public string $password;
    public string $phone;
    public string $address;

    public function __construct(Request $req)
    {
        $this->email = $req->input("email");
        $this->fullName = $req->input("fullName");
        $this->password = $req->input("password");
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'fullName' => 'required',
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}
