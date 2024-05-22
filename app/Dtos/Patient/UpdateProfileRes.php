<?php
namespace App\Dtos\Patient;
use Illuminate\Http\Request;

class UpdateProfileRes
{
    public string $id;
    public string $email;
    public string $password;
    public string $fullName;
    public string $address;
    public string $phone;
    public ?string $image;
    public ?string $healthCondition;
    public ?string $note;

    public function __construct(Request $req)
    {
        $this->id = $req->id;
        $this->email =$req->email;
        $this->password = $req->password;
        $this->fullName = $req->fullName;
        $this->address = $req->address;
        $this->phone = $req->phone;
        $this->image = $req->image;
        $this->healthCondition = $req->healthCondition ?? '';
        $this->note = $req->note ?? '';
    }
    public function rules(): array
    {
        return [
            'id' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'fullName' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'image' => 'nullable|url',
            'healthCondition' => 'nullable|string',
            'note' =>'nullable|string'
        ];
    }
}