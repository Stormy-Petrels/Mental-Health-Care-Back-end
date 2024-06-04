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
        $sql = "INSERT INTO $this->tableName (id, role, email, password, fullName, address, phone, urlImage, isActive, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $user->getId(),
            $user->getRole()->getValue(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getFullName(),
            $user->getAddress(),
            $user->getPhone(),
            $user->getUrlImage(),
            $user->getStatus(),
            Carbon::now(),
            Carbon::now()
        ]);
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
                $newUser->urlImage == null ? "" : $newUser->urlImage,
                $newUser->isActive
            );
        }
        return null;
    }


    public function updateStatusUsersActive($userId)
    {
        $user = DB::update("UPDATE users SET users.isActive = '1' WHERE users.id = $userId;");


        // if ($user > 0) {
            $result = DB::select("SELECT * FROM users WHERE users.id = $userId");
            $transferResult = $result[0];


            return new User(
                $transferResult->role === "patient" ? Role::Patient : ($transferResult->role === "cashier" ? Role::Cashier : Role::Doctor),
                $transferResult->email,
                $transferResult->password,
                $transferResult->fullName,
                $transferResult->phone == null ? "" : $transferResult->phone,
                $transferResult->address == null ? "" : $transferResult->address,
                $transferResult->urlImage == null ? "" : $transferResult->urlImage
            );
        // }
        //   return null;
    }


    public function updateStatusUsersInactive($userId)
    {
        $user = DB::update("UPDATE users SET users.isActive = '0' WHERE users.id = $userId;");


        if ($user > 0) {
            $result = DB::select("SELECT * FROM users WHERE users.id = $userId");
            $transferResult = $result[0];


            return new User(
                $transferResult->role === "patient" ? Role::Patient : ($transferResult->role === "cashier" ? Role::Cashier : Role::Doctor),
                $transferResult->email,
                $transferResult->password,
                $transferResult->fullName,
                $transferResult->phone == null ? "" : $transferResult->phone,
                $transferResult->address == null ? "" : $transferResult->address,
                $transferResult->urlImage == null ? "" : $transferResult->urlImage
            );
        }
        return null;
    }


    
}