<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserGroupSeeder::class,
            CustomerSeeder::class,
        ]);

        \App\Models\User::create([
            'name' => 'Admin',
            'surname' => 'Guarino',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email' => 'admin@guarino.com',
            'user_group_id' => 1
        ]);
    }
}
