<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    private $users = [
        [
            'name' => 'admin1',
            'email' => 'admin1@admin.com',
            'password' => 'password',
            'is_admin' => true,
        ],
        [
            'name' => 'admin2',
            'email' => 'admin2@admin.com',
            'password' => 'password',
            'is_admin' => true,
        ],
    ];

    public function run(): void
    {
        foreach ($this->users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'is_admin' => $user['is_admin'],
            ]);
        }
    }
}
