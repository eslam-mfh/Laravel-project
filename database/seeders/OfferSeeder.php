<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::insert([
            [
                'name' => 'offer1',
                'description' => 'offer1',
                'price' => '2500',
                'end' => '2024/09/30',
            ]
        ]);
    }
}
