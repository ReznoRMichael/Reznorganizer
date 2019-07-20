<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $faker -> text(45),
        'description' => $faker -> text(191),
        'notes' => $faker -> text(200),
        'owner_id' => factory(App\User::class)
    ];
});
