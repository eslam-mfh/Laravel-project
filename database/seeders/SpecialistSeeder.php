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
            ],
            [
                'name' => 'Ph.Yara taki aldeen',
                'description' => '4 years experience',
            ],
            ///////////
            [
                'name' => 'Dr.Nazmi derwan',
                'description' => '4 years experience',
            ],
            ///////////
            [
                'name' => 'Fatima alazn',
                'description' => '4 years experience',
            ],
            /////////
            [
                'name' => 'Dr.loriel domt',
                'description' => '6 years experience',
            ],
            [
                'name' => 'Dr.Hasan alsosi',
                'description' => '5 years experience',
            ],
            [
                'name' => 'Dr.Ghanwa abboud',
                'description' => '4 years experience',
            ],
            ///////////
            [
                'name' => 'Nour',
                'description' => '4 years experience',
            ],
            [
                'name' => 'Solaf',
                'description' => '2 years experience',
            ],
            [
                'name' => 'Anwar',
                'description' => '2 years experience',
            ],



        ]);
    }
}
