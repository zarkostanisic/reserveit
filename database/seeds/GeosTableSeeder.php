<?php

use Illuminate\Database\Seeder;
use App\Geo;

class GeosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Geo::class, 10)->create()->each(function($city){
        	$city->municipalities()->saveMany(
                factory(Geo::class, rand(1, 5))->make()
            );
        });
    }
}
