<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class ProfileReq
{
    public ?string $id;

    public function __construct(Request $req)
    {
        $this->id = $req->input("id");
    }

    public function rules(): array
    {
        return [
            'id' => 'required'
        ];
    }
}
