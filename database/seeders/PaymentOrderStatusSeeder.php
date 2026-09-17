<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Pagato',
                'bs_color' => 'success'
            ],
            [
                'name' => 'Deve pagare',
                'bs_color' => 'warning'
            ],
            [
                'name' => 'Acconto',
                'bs_color' => 'secondary'
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\PaymentOrderStatus::create($status);
        }
    }
}
