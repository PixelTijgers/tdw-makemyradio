<?php

// Namespacing.
namespace Database\Seeders;

// Facades.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models.
use App\Models\Details;

class DetailsSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Details::create([
            'name' => 'Pixeltijgers',
            'contact' => 'Michiel Elshout',
            'street' => 'Vier ambachtenstraat 5',
            'zip_code' => '4551 HP',
            'location' => 'Sas van Gent',
            'country' => 'Nederland',
            'email' => 'info@pixeltijgers.nl',
            'mobile' => '+31 (0)6 13 54 22 34',
            'coc' => '80856772',
            'vat' => 'NL003498167B54',
            'bank' => 'NL72 BUNQ 2049 7203 19',
        ]);
    }
}
