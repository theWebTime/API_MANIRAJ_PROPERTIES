<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeOfProperty;

class TypeOfPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['no_bhk' => '1 BHK'],
            ['no_bhk' => '2 BHK'],
            ['no_bhk' => '3 BHK'],
            ['no_bhk' => '4 BHK'],
            ['no_bhk' => '5 BHK'],
        ];
        TypeOfProperty::insert($data);
    }
}
