<?php

namespace Database\Seeders;

use App\Models\Reviews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reviews::insert([
            [
                'user_id' => 4,
                'session_id' => 3,
                'review' => 'my review ',
            ],
            [
                'user_id' => 4,
                'review' => 'my review 1',
                'type' => '1',
            ],
            [
                'user_id' => 4,
                'review' => 'my review 2',
                'type' => '2',
            ],
            [
                'user_id' => 4,
                'review' => 'my review 3',
                'type' => '1',
            ],
            [
                'user_id' => 4,
                'review' => 'my review 4',
                'type' => '1',
            ],
        ]);
    }
}
