<?php 
namespace App\Dtos\Admin;
use App\Models\BaseModel;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorReq extends BaseModel
{
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
        $data = [
            'email' => $req->input("email"),
            'password' => $req->input("password"),
            'fullName' => $req->input("fullName"),
            'phone' => $req->input("phone"),
            'address' => $req->input("address"),
            'healthCondition' => $req->input("healthCondition"),
            'note' => $req->input("note"),
            'urlImage' => $req->input("urlImage"),
            'isActive' => $req->input("isActive")

        ];
    
        $validator = Validator::make($data, $this->rules());
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400)->throwResponse();
        }
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
            'email' => 'required|email|unique:users,email',
            'fullName' => 'required',
            'password' => 'required|min:8',
            'phone' => 'required',
            'address' => 'required',
            'description' => 'required',
            'major' => 'required',
            'urlImage' => 'required',
            'isActive' => 'required'
        ];
    }
}