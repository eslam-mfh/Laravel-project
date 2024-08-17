<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SocialLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_links')->insert([
            ['platform' => 'Facebook', 'url' => 'https://www.facebook.com/dahabbeautyclinic/'],
            ['platform' => 'Instagram', 'url' => 'https://www.instagram.com/dahab_beauty_clinic_original?igsh=MWxoMnRzOHloczNwcw=='],
                ['platform' => 'Phone Number', 'url' => '+963940112444'],
                ['platform' => 'Number', 'url' => '011-4454993'],
                ['platform' => 'Number', 'url' => '011-4454994'],
        ]);

    }
}
