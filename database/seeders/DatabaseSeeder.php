<?php

// Namespacing.
namespace Database\Seeders;

// Facades.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            // Administrator seeders.
            AdministratorSeeder::class,
            AdministratorPermissionsSeeder::class,

            // Navigation seeders.
            NavigationMenuSeeder::class,
            Menu\MainSeeder::class,
            Menu\FooterSeeder::class,
            Menu\StandAloneSeeder::class,

            // Website seeders.
            CategorySeeder::class,
            DetailsSeeder::class,
            LocaleSeeder::class,
            //PageSliderSeeder::class,

            // Social media seeder.
            SocialMediaSeeder::class,
            SocialSeeder::class,
        ]);

        // Only run factories on local or staging env.
        if (\App::environment(['local', 'staging'])) {

            // Call factories.
            \App\Models\Post::factory()->count(150)->create();
        }
    }
}
