<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'hibawanly',
                'email' => 'hiba.wanly@gmail.com',
                'password' => Hash::make('hiba12345'),
                'role_id' => 2, // admin
            ],
            [
                'name' => 'eslam',
                'email' => 'eslam@gmail.com',
                'password' => Hash::make('eslam12345'),
                'role_id' => 3,
            ],
            [
                'name' => 'bassma',
                'email' => 'bassma@gmail.com',
                'password' => Hash::make('bassma12345'),
                'role_id' => 3,
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user12345'),
                'role_id' => 1, // assuming 1 is the default role for regular users
            ],
        ]);
    }
}
