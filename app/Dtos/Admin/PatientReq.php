<?php 

namespace App\Dtos\Admin;

use App\Models\BaseModel;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'fullName' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'healthCondition' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:500'],
            'urlImage' => ['nullable', 'string', 'max:255'],
            'isActive' => ['nullable', 'boolean'],
        ];
    }

  
}