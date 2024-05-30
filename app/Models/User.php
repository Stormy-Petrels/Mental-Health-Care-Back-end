<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends BaseModel
{
    private string $userId;
    private Role $role;
    private string $email;
    private string $password;
    private string $fullName;
    private string $address;
    private string $phone;
    private string|null $urlImage;
    private string|null $isActive;

    public function __construct(
        Role $role,
        string $email,
        string $password,
        string|null $fullName,
        string $address,
        string $phone,
        string|null $urlImage = null,
        string|null $isActive = null
    ) {
        parent::__construct();
        $this->role = $role;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName ?? '';
        $this->address = $address;
        $this->phone = $phone;
        $this->urlImage = $urlImage;
        $this->isActive = $isActive;
    }
    public function getRole(): Role
    {
        return $this->role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getUrlImage(): string
    {
        return $this->urlImage == null ? "" : $this->urlImage;
    }

    public function setUrlImage(string $urlImage): void
    {
        $this->urlImage = $urlImage;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    

    public function getStatus(): string
    {
        return $this->isActive == null ? "" : $this->isActive;
    }
    public function getUserId(): string
    {
        return $this->userId;
    }
}