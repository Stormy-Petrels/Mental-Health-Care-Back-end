<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

class PatientReq
{
    public string $healthCondition;
    public string $note;

    public function __construct(Request $req)
    {
        $this->healthCondition = $req->input("healthCondition");
        $this->note = $req->input("note");
    }

    public function rules(): array
    {
        return [
            'healthCondition' => 'required',
            'note' =>'required',
        ];
    }
}
