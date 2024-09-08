<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository extends BaseRepository{
    public function getModel()
    {
        return User::class;
    }

    public function getUserByEmail($email): User|null
    {
        return $this->getModel()::where('email', $email)->first();

    }
}
