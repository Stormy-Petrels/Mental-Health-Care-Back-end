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
        $sql = "INSERT INTO $this->tableName (id, role, email, password, fullName, address, phone, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $user->getId(),
            $user->getRole()->getValue(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
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
                $newUser->fullName,
                $newUser->address == null ? "" : $newUser->address,
                $newUser->phone == null ? "" : $newUser->phone,
                $newUser->urlImage == null ? "" : $newUser->urlImage
            );
        }
        return null;
    }
}