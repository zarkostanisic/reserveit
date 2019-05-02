<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Company;
use Faker\Generator as Faker;
use App\Geo;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'city_id' => function(){
            return Geo::all()->random();
        }
    ];
});
