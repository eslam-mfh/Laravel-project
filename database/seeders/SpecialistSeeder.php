<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialists')->insert([
            [
                'name' => 'Dr.Yara taki aldeen',
                'description' => '4 years experience',
                'specialization' => 'Skin care'
            ],
            [
                'name' => 'Ph.massa shbib',
                'description' => '4 years experience',
                'specialization' => 'Skin care'
            ],
            ///////////
            [
                'name' => 'Dr.Nazmi derwan',
                'description' => '4 years experience',
                'specialization' => 'Dental care'
            ],
            ///////////
            [
                'name' => 'Fatima alazn',
                'description' => '4 years experience',
                'specialization' => 'Dental care'
            ],
            /////////
            [
                'name' => 'Dr.loriel domt',
                'description' => '6 years experience',
                'specialization' => 'Plastic surgery'
            ],
            [
                'name' => 'Dr.Hasan alsosi',
                'description' => '5 years experience',
                'specialization' => 'Plastic surgery'

            ],
            [
                'name' => 'Dr.Ghanwa abboud',
                'description' => '4 years experience',
                'specialization' => 'Plastic surgery'
            ],
            ///////////
            [
                'name' => 'Nour',
                'description' => '4 years experience',
                'specialization' => 'Laser'
            ],
            [
                'name' => 'Solaf',
                'description' => '2 years experience',
                'specialization' => 'Laser'
            ],
            [
                'name' => 'Anwar',
                'description' => '2 years experience',
                'specialization' => 'Laser'
            ],



        ]);
    }
}
