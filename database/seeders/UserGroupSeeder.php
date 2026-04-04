<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\UserGroup::create([
            'name' => 'Admin',
            'description' => 'Administrators with full access to the system.'
        ]);
    }
}
