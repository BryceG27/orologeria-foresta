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
                'bs_color' => 'primary'
            ],
            [
                'name' => 'Attesa risposta',
                'bs_color' => 'info'
            ],
            [
                'name' => 'Chiuso',
                'bs_color' => 'warning'
            ],
            [
                'name' => 'Consegnato',
                'bs_color' => 'success'
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\WorkingStatus::create($status);
        }
    }
}
