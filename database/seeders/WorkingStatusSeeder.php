<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WorkingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Aperto',
                'bs-color' => 'primary'
            ],
            [
                'name' => 'Attesa risposta',
                'bs-color' => 'info'
            ],
            [
                'name' => 'Chiuso',
                'bs-color' => 'warning'
            ],
            [
                'name' => 'Consegnato',
                'bs-color' => 'success'
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\WorkingStatus::create($status);
        }
    }
}
