<?php

namespace App\Repositories;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminRepository
{
    private string $tableName = "admins";

    function queryAllDoctors() : array
    {
        $sql = "SELECT * FROM $this->tableName";
        return DB::select($sql);
    }
}