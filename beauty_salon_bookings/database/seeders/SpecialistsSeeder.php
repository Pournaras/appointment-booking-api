<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialist;

class SpecialistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialist::insert([
            ['name' => 'Specialist1'],
            ['name' => 'Specialist2'],
            ['name' => 'Specialist3'],
        ]);
    }
}
