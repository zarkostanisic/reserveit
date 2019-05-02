<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Geo;
use Faker\Generator as Faker;

$factory->define(Geo::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
