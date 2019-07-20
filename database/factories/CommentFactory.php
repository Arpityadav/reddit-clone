<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create(),
        'thread_id' => factory('App\Thread')->create(),
        'body' => $faker->sentence
    ];
});
