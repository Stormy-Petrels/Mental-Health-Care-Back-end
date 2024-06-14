<?php

namespace App\Dtos\Common;

    /**
     * @OA\Schema(
     *     schema="SignInResCommon",
     *     type="object",
     *     title="SignInRes",
     *     description="Response object for user sign-in",
     *     required={"roleId", "role", "email", "fullName", "password", "address", "phone", "image"}
     * )
     */
    class SignInRes
    {
        /**
         * @OA\Property()
         * @var string
         */
        public string $roleId;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $role;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $email;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $password;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $fullName;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $address;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $phone;
    
        /**
         * @OA\Property()
         * @var string
         */
        public string $image;

    /**
     * @param string $id
     * @param string $role
     * @param string $email
     * @param string $fullName
     */
    public function __construct(string $roleId, string $role, string $email, string $fullName, string $password, string $address, string $phone, string $image)
    {
        $this->roleId = $roleId;
        $this->role = $role;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->address = $address;
        $this->phone = $phone;
        $this->image = $image;
    }
}