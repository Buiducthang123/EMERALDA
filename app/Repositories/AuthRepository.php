<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository extends BaseRepository{
    public function getModel()
    {
        return User::class;
    }
    public function getUserByUsername($email): User
    {
        return $this->getModel()::where('email', $email)->first();
    }
}
