<?php

namespace App\Modules\Users\Http\Services;

use App\Modules\Users\DTO\UserData;
use App\Users\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function storeUser(array $user): User
    {
        $userData = new UserData(
            login: (string)$user['login'],
            password: Hash::make((string)$user['password']),
            name: (string)$user['name'],
            email: (string)$user['email'],
            id: null,
        );
        return $this->storeData($userData);
    }

    private function storeData(UserData $userData): User
    {
        return User::create([
            'name' => $userData->name,
            'login' => $userData->login,
            'email' => $userData->email,
            'password' => $userData->password,
        ]);
    }

    public function updateUser(array $user): void
    {
        $userData = new UserData(
            login: (string)$user['login'],
            password: Hash::make((string)$user['password']),
            name: (string)$user['name'],
            email: (string)$user['email'],
            id: $user['id'],
        );
        $this->updateData($userData);
    }

    private function updateData(UserData $userData): void
    {
        User::find($userData->id)->update([
            'name' => $userData->name,
            'login' => $userData->login,
            'email' => $userData->email,
            'password' => $userData->password,
        ]);
    }
}