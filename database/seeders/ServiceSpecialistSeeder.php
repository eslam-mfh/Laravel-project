<?php

namespace Database\Seeders;

use App\Models\Service_Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service_Specialist::insert([
            [
                'specialist_id' => 1,
                'service_id' => 1,
            ]
        ]);
    }
}
