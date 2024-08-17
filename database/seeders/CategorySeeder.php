<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Skin care',
                'description' => 'Dermatology department',
                'image' => '/images/skin.jpeg',
            ],
            [
                'name' => 'Dental care',
                'description' => 'Dental department',
                'image' => '/images/dental.jpeg',

            ],
            [
                'name' => 'Nutrition',
                'description' => 'Body health',
                'image' => '/images/nut.png',

            ],
            [
                'name' => 'Plastic surgery',
                'description' => 'Cosmetic department',
                'image' => '/images/plastic.jpeg',

            ],
            [
                'name' => 'Laser Cynosure apooge ',
                'description' => 'Hair removal',
                'image' => '/images/cynosure.jpeg',
            ],
            [
                'name' => 'Laser Lumenis splendor X',
                'description' => 'Hair removal',
                'image' => '/images/lumenis.jpeg',
            ],
            [
                'name' => 'Laser AMI',
                'description' => 'Hair removal',
                'image' => '/images/ami.jpeg',
            ],


        ]);
    }
}
