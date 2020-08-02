<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $vector_avatar = [
        'https://semantic-ui.com/images/avatar2/large/elyse.png',
        'https://semantic-ui.com/images/avatar2/large/matthew.png',
        'https://semantic-ui.com/images/avatar2/large/kristy.png',
        'https://semantic-ui.com/images/avatar2/large/molly.png',
        'https://semantic-ui.com/images/avatar/large/elliot.jpg',
        'https://semantic-ui.com/images/avatar/large/jenny.jpg',
        'https://semantic-ui.com/images/avatar/large/steve.jpg',
        'https://semantic-ui.com/images/avatar/large/daniel.jpg',
        'https://semantic-ui.com/images/avatar/large/helen.jpg',
        'https://semantic-ui.com/images/avatar/large/elliot.jpg',
        'https://semantic-ui.com/images/avatar/large/stevie.jpg',
        'https://semantic-ui.com/images/avatar/large/veronika.jpg'
    ];
    return [
        'username' => $faker->name,
        'avatar' => $vector_avatar[rand(0, count($vector_avatar) - 1)],
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});
