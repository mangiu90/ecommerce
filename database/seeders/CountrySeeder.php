<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory(3)->create()->each(function(Country $country) {
            Province::factory(5)->create([
                'country_id' => $country->id,
            ])->each(function(Province $province) {
                City::factory(10)->create([
                    'province_id' => $province->id,
                ]);
            });
        });
    }
}
