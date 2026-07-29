<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialist;

class SpecialistServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specialist::find(1)->services()->attach([1, 2]);

        Specialist::find(2)->services()->attach([1, 3]);

        Specialist::find(3)->services()->attach([2, 3]);
    }
}
