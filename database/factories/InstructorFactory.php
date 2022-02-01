<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Instructor;
use Faker\Generator as Faker;

$factory->define(Instructor::class, function (Faker $faker) {
    return [
        'name' => $faker -> name,
        'email' => $faker -> email,
        'phone' => $faker -> phoneNumber,
        'status' => 1
    ];
});
