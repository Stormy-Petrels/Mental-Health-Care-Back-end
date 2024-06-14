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
        $user = DB::table('users')
            ->where('email', $email)
            ->first();

        if ($user) {
            $role = $this->mapRole($user->role);

            return new User(
                $role,
                $user->email,
                $user->password,
                $user->fullName,
                $user->address ?? '',
                $user->phone ?? '',
                $user->urlImage ?? '',
                $user->isActive
            );
        }

        return null;
    }

    private function mapRole($roleString)
    {
        return match ($roleString) {
            'admin' => Role::Admin,
            'doctor' => Role::Doctor,
            default => Role::Patient,
        };
    }


    public function updateStatusUsersActive($userId)
    {
        $user = DB::update("UPDATE users SET users.isActive = '1' WHERE users.id = $userId;");
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