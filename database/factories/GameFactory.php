<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameModel;
use App\Models\UserModel;
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

$factory->define(GameModel::class, function (Faker $faker) {
    $user_score = $faker->randomNumber(1);
    $cpu_score = $faker->randomNumber(1);
    return [
        'user_score' => $user_score,
        'cpu_score' => $cpu_score,
        'has_won' => ($user_score > $cpu_score),
        'user_id' => $faker->randomElement(UserModel::pluck('id')->all()),
    ];
});
