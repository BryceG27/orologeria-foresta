<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Contanti',
                'slug' => 'contanti'
            ],
            [
                'name' => 'Carta di credito',
                'slug' => 'carta-di-credito'
            ],
            [
                'name' => 'Bonifico',
                'slug' => 'bonifico'
            ],
        ];

        foreach ($methods as $method) {
            \App\Models\PaymentMethod::create($method);
        }
    }
}
