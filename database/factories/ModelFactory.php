<?php
use Illuminate\Hashing\BcryptHasher;
use App\Models\User;
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

$factory->define(User::class, function (Faker\Generator $faker) {
    $bcrypt = new BcryptHasher();
    return [
        'email' => $faker->email,
        'roleId' => rand(1,2),
        'password' => $bcrypt->make('12345678'),
    ];
});
