<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'judul'=>$faker->word(),
        'cover'=>$faker->imageUrl(),
        'konten'=>$faker->text(),
        'jumlah_like'=>$faker->randomNumber(),

        'avatar_penulis'=>$faker->imageUrl(),
        'nama_penulis'=>$faker->name(),
    ];
});
