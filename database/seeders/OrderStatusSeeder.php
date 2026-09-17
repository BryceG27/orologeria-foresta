<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
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
                'name' => 'Arrivato',
                'bs_color' => 'info'
            ],
            [
                'name' => 'Consegnato',
                'bs_color' => 'success'
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\OrderStatus::create($status);
        }
    }
}
