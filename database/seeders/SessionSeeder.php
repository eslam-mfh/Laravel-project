<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::insert([
            [
                'user_id'=>4,
                'available_slots_id'=>2,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '11:00:00',
                'status'=>'0', //pending
                'type'=>'0',
            ],
            [
                'user_id'=>4,
                'available_slots_id'=>3,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '09:30:00',
                'status'=>'1',
                'type'=>'0',
            ],
            [
                'user_id'=>4,
                'available_slots_id'=>4,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '10:00:00',
                'status'=>'2', //completed
                'type'=>'0',
            ],
            [
                'user_id'=>4,
                'available_slots_id'=>5,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '10:30:00',
                'status'=>'3', //refused
                'type'=>'0',
            ],
            [
                'user_id'=>4,
                'available_slots_id'=>6,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '11:30:00',
                'status'=>'0', //pending
                'type'=>'0',
            ],
            [
                'user_id'=>4,
                'available_slots_id'=>7,
                'service'=>'service1',
                'specialist'=>'specialist1',
                'date' => '2024-08-3',
                'time' => '12:00:00',
                'status'=>'0', //pending
                'type'=>'1', //offer
            ],
        ]);
    }
}
