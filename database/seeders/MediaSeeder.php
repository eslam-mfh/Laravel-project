<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media')->insert(
            [
            [
                'file_name_1' => '/images/botoxbe.jpg',
                'file_name_2' => '/images/botoxaf.jpg',
                'description' => 'Botox'
            ],
            [
                'file_name_1' => '/images/fillerbe.jpg',
                'file_name_2' => '/images/filleraf.jpg',
                'description' => 'Filler'
            ],
            [
                'file_name_1' => '/images/fillerbe1.jpg',
                'file_name_2' => '/images/filleraf1.jpg',
                'description' => 'Filler'
            ],
            [
                'file_name_1' => '/images/fillerbe2.jpg',
                'file_name_2' => '/images/filleraf2.jpg',
                'description' => 'Chin Filler'
            ],
            [
                'file_name_1' => '/images/fillerbe3.jpg',
                'file_name_2' => '/images/filleraf3.jpg',
                'description' => 'Filler'
            ],
            [
                'file_name_1' => '/images/fibe4.jpg',
                'file_name_2' => '/images/fiaf4.jpg',
                'description' => 'Filler'
            ],
            [
                'file_name_1' => '/images/hairbe.jpg',
                'file_name_2' => '/images/hairaf.jpg',
                'description' => 'Hair transplant'
            ],
            [
                'file_name_1' => '/images/skinbe.jpg',
                'file_name_2' => '/images/skinaf.jpg',
                'description' => 'Deep skin cleansing'
            ],



        ]
    );
    }
}
