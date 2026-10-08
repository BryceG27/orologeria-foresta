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
                'bs_color' => 'danger'
            ],
            [
                'name' => 'Acconto',
                'bs_color' => 'warn'
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\PaymentOrderStatus::create($status);
        }
    }
}
