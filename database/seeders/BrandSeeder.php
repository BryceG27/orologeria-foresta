<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Zenith',
                'slug' => 'zenith'
            ],
            [
                'name' => 'Tag Heuer',
                'slug' => 'tag-heuer'
            ],
            [
                'name' => 'Omega',
                'slug' => 'omega'
            ],
            [
                'name' => 'Longines',
                'slug' => 'longines'
            ],
            [
                'name' => 'Hamilton',
                'slug' => 'hamilton'
            ],
            [
                'name' => 'Tissot',
                'slug' => 'tissot'
            ],
            [
                'name' => 'Seiko',
                'slug' => 'seiko'
            ],
            [
                'name' => 'Rolex',
                'slug' => 'rolex'
            ]
        ];

        foreach ($brands as $brand) {
            \App\Models\Brand::create($brand);
        }
    }
}
