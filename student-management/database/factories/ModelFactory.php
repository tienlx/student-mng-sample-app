<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Illuminate\Hashing\BcryptHasher;
//$factory->define(App\User::class, function ($faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->email,
//    ];
//});

$factory->define(App\Teacher::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->email,
        'phone' => $faker->phoneNumber,
        'profession' => $faker->randomElement($array = array('engineering', 'math', 'physic'))
    ];
});

$factory->define(App\Student::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->email,
        'phone' => $faker->phoneNumber,
        'career' => $faker->randomElement($array = array('engineering', 'math', 'physic'))
    ];
});

$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->paragraph(4),
        'value' => $faker->numberBetween(1, 4),
        'teacher_id' => mt_rand(1, 50)
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => (new BcryptHasher)->make('1234')
    ];
});
