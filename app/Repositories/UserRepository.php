<?php
namespace App\Repositories;
use Illuminate\Support\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    private string $tableName = "users";


    public function insert(User $user)
    {
        $sql = "INSERT INTO $this->tableName (id, role, name, email, password, phone, address, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $user->getId(),
            $user->getRole()->getValue(),
            $user->getFullname(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getAddress(),
            Carbon::now(),
            Carbon::now()
        ]);
    }
    public function selectAll()
    {
    }

    public function update(User $model)
    {
    }

    public function delete(string $id)
    {
    }
    

    public function findByEmail($email)
    {
        $result = DB::select("SELECT * FROM users
        WHERE email = ? LIMIT 1", [$email]);

        if (!empty($result)) {
            $newUser = $result[0];
            if ($newUser->role == "admin") {
                $role = Role::Admin;
            } elseif ($newUser->role == "doctor") {
                $role = Role::Doctor;
            } else {
                $role = Role::Patient;
            }
            return new User(
                $role,
                $newUser->email,
                $newUser->password,
                $newUser->name,
                $newUser->phone == null ? "" : $newUser->phone,
                $newUser->address == null ? "" : $newUser->address,
                $newUser->url_image == null ? "" : $newUser->url_image
            );
        }
        return null;
    }
}