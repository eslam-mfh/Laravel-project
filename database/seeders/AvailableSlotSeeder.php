<?php

namespace Database\Seeders;

use App\Models\AvailableSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailableSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AvailableSlot::insert([
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '09:00:00',
                'is_booked'=>0 ,
            ] ,
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '11:00:00',
                'is_booked'=>1 ,
            ],
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '09:30:00',
                'is_booked'=>1 ,
            ] ,
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '10:00:00',
                'is_booked'=>1 ,
            ] ,
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '10:30:00',
                'is_booked'=>1 ,
            ] ,
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '11:30:00',
                'is_booked'=>1 ,
            ] ,
            [
                'specialist_id' => 1,
                'service_id' => 1,
                'date' => '2024-08-3',
                'time' => '12:00:00',
                'is_booked'=>0 ,
            ] ,
        ]);
    }
}
