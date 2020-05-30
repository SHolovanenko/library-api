<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Book::class, function (Faker $faker) {
    $title = $faker->sentence(rand(2,5));

    return [
        'alias' => Str::slug($title),
        'title' => $title,
        'description' => $faker->text(rand(20, 100)),
        'category_id' => rand(1,5)
    ];
});
