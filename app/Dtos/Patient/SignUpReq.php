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
<<<<<<< HEAD
        $this->email = $req->input("email") ?? "";
        $this->fullName = $req->input("fullName") ?? "";
        $this->password = $req->input("password") ?? "";
        $this->phone = $req->input("phone") ?? "";
        $this->address = $req->input("address") ?? "";
=======
        $this->email = $req->input("email");
        $this->fullName = $req->input("fullName");
        $this->password = $req->input("password");
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
>>>>>>> 3c9a36611aedf3d1b4d6c78b96466b59178a6182
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
