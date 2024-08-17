<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PassportSeeder::class,
            // other seeders
        ]);

        $this->call(RolesSeeder::class);
        $this->call(SocialLinksSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(SpecialistSeeder::class);
        $this->call(ServiceSpecialistSeeder::class);
        $this->call(AvailableSlotSeeder::class);
        $this->call(SessionSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(OfferSeeder::class);




    }
}
