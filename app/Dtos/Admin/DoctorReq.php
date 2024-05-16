<?php 

namespace App\Dtos\Admin;

use App\Models\BaseModel;
use App\Models\Role;
use Illuminate\Http\Request;

class DoctorReq extends BaseModel
{
    public  $userId;
    public Role $role;
    public string $email;
    public string $password;
    public string $fullName;
    public string $phone;
    public string $address;
    public string $description;
    public string $major;
    public string|null $urlImage = null;
    public string|null $isActive = null;

    public function __construct(Request $req)
    {
        $this->role = Role::Doctor;
        $this->email = $req->input("email");
        $this->password = $req->input("password");
        $this->fullName = $req->input("fullName");
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
        $this->description = $req->input("description");
        $this->major = $req->input("major");
        $this->urlImage = $req->input("urlImage");
        $this->isActive = $req->input("isActive");
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'fullName' => 'required',
            'password' => 'required|min:6',
            'phone' => 'required',
            'address' => 'required',
            'description' => 'required',
            'major' => 'required',
            'urlImage' => 'required',
            'isActive' => 'required'
        ];
    }
}