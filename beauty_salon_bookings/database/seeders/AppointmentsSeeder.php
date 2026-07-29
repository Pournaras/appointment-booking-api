<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::insert([
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'appointment_date' => '2027-06-01',
                'start_time' => '09:30:00',
                'end_time' => '10:20:00',
            ],
            [
                'specialist_id' => 2,
                'service_id' => 3,
                'appointment_date' => '2027-06-01',
                'start_time' => '10:30:00',
                'end_time' => '10:55:00',
            ],
            [
                'specialist_id' => 1,
                'service_id' => 2,
                'appointment_date' => '2027-06-01',
                'start_time' => '11:00:00',
                'end_time' => '12:10:00',
            ],
            [
                'specialist_id' => 3,
                'service_id' => 3,
                'appointment_date' => '2027-06-01',
                'start_time' => '15:30:00',
                'end_time' => '15:55:00',
            ],
            [
                'specialist_id' => 2,
                'service_id' => 3,
                'appointment_date' => '2027-06-02',
                'start_time' => '09:30:00',
                'end_time' => '09:55:00',
            ],
            [
                'specialist_id' => 3,
                'service_id' => 2,
                'appointment_date' => '2027-06-02',
                'start_time' => '14:00:00',
                'end_time' => '15:10:00',
            ],
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'appointment_date' => '2027-06-03',
                'start_time' => '10:00:00',
                'end_time' => '10:50:00',
            ],
            [
                'specialist_id' => 3,
                'service_id' => 3,
                'appointment_date' => '2027-06-03',
                'start_time' => '11:00:00',
                'end_time' => '11:25:00',
            ],
            [
                'specialist_id' => 2,
                'service_id' => 1,
                'appointment_date' => '2027-06-03',
                'start_time' => '14:00:00',
                'end_time' => '14:50:00',
            ],
        ]);
    }
}
