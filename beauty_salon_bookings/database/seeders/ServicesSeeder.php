<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'name' => 'Haircut',
                'duration' => '00:50:00',
            ],
            [
                'name' => 'Hairstyling',
                'duration' => '01:10:00',
            ],
            [
                'name' => 'Manicure',
                'duration' => '00:25:00',
            ],
        ]);
    }
}
