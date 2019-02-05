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

$factory->define(App\Models\Transfer::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat(2, 1, $max = 100),
        'is_processed' => true,
        'created_at' => $dateTime = $faker->dateTimeThisYear('now'),
        'updated_at' => $dateTime,
    ];
});
