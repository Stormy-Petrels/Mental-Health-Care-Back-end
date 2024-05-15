<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashier extends BaseModel
{
    public User $user;
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }
}