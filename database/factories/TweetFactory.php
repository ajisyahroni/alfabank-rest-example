<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    return [
        'username' => $faker->name(),
        'tweet' => $faker->text(),
        'time' => rand(10, 50) . ' menit yang lalu',
    ];
});
