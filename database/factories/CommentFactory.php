<?php

/** @var Factory $factory */

use App\Article;
use App\Comment;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'description' => $faker->text,
        'article_id' => function () {
            return Article::all()->random(1)->first();
        },
        'user_id' => function () {
            return User::all()->random(1)->first();
        },
    ];
});
