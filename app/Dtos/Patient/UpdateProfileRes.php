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
    public string $image;
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
}