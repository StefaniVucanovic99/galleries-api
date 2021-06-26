<?php

use Faker\Generator as Faker;

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

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text($maxNbChars = 1000),
        'user_id' => \App\User::inRandomOrder()->first()->id, //vadim random usera iz baze i uzimam njegov id
        'gallery_id' => \App\Gallery::inRandomOrder()->first()->id,
    ];
});
