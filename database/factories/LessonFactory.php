<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    $date = \Carbon\Carbon::create(2019, 11, rand(18,24), rand(6,23));
    $duration = [45, 55, 65, 70, 75, 80];
    $instructors = [1,2,3,4,5,6,7,8,9,10,11];
    $types = ['classic', 'power', 'interval'];
    return [
        'id_instructor' => $instructors[rand(0,10)],
        'tipo' => $types[rand(0,2)],
        'start' =>$date->format('Y-m-d H:i:s'),
        'end'   => $date->addMinutes($duration[rand(0,5)])->format('Y-m-d H:i:s'),
        'limit_people' => 20,
        'status' => 1,
    ];
});
