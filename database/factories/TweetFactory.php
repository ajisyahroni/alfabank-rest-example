<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {

    return [
        // 'avatar' => $vector_avatar[rand(0, count($vector_avatar))],
        // 'username' => $faker->name(),
        'user_id' => 1,
        'tweet' => $faker->text(),
        'time' => Carbon::now()->diffForHumans(),
    ];
});
