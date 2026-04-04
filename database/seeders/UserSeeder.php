<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Fabrizio',
                'surname' => 'Guarino',
                'username' => 'f.guarino',
                'password' => Hash::make('password'),
                'email' => 'fabrizio1.guarino@gmail.com',
                'user_group_id' => 1
            ],
            [
                'name' => 'Giuseppe',
                'surname' => 'Meduri',
                'username' => 'g.meduri',
                'password' => Hash::make('password'),
                'email' => 'giuseppe.meduri@gmail.com',
                'user_group_id' => 1
            ]
        ];

        User::createMany($users);
    }
}
