<?php
namespace App\Dtos\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileReq
{
    public string $id;

    public function __construct(Request $req)
    {
        $data = [
            'id' => $req->input("id"),
        ];
    
        $validator = Validator::make($data, $this->rules());
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400)->throwResponse();
        }
        $this->id = $req->input("id");
    }
    public function rules(): array
    {
        return [
            'id' => 'required'
        ];
    }
}