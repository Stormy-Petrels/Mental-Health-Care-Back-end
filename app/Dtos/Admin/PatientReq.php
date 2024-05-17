<?php 

namespace App\Dtos\Admin;

use App\Models\BaseModel;
use App\Models\Role;
use Illuminate\Http\Request;

class PatientReq extends BaseModel
{
    public  $userId;
    public Role $role;
    public string $email;
    public string $password;
    public string $fullName;
    public string $phone;
    public string $address;
    public string $healthCondition;
    public string $note;
    public string|null $urlImage = null;
    public string|null $isActive = null;

    public function __construct(Request $req)
    {
        $this->role = Role::Patient;
        $this->email = $req->input("email");
        $this->password = $req->input("password");
        $this->fullName = $req->input("fullName");
        $this->phone = $req->input("phone");
        $this->address = $req->input("address");
        $this->healthCondition = $req->input("healthCondition");
        $this->note = $req->input("note");
        $this->urlImage = $req->input("urlImage");
        $this->isActive = $req->input("isActive");
    }

  
}