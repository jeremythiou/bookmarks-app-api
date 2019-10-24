<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookmark;
use Faker\Generator as Faker;
use App\User;

$factory->define(Bookmark::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'url' => $faker->url,
        'user_id' => $faker->numberBetween(1, 5),
        'summary' => $faker->sentence(15, true),
    ];
});
