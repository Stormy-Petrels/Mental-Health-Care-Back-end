<?php

namespace App\Dtos\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MajorReq
{

    public string $id;
    public string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
