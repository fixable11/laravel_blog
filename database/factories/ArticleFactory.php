<?php

/** @var Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'user_id' => function () {
            return User::all()->random(1)->first();
        },
    ];
});
