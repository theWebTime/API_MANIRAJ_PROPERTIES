<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CommercialType;

class CommercialTypeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['type' => 'Office'],
            ['type' => 'Showroom'],
            ['type' => 'Shop'],
        ];
        CommercialType::insert($data);
    }
}
