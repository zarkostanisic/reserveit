<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Company;
use Faker\Generator as Faker;
use App\Geo;
use App\Category;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address,
        'city_id' => function(){
            return Geo::all()->random();
        },
        'category_id' => function(){
            return Category::all()->random();
        },
    ];
});
