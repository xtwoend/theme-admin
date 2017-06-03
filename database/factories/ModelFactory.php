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

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Entities\Jurusan::class, function(Faker\Generator $faker) {
    return [
        'nama' => $faker->name,
        'keterangan' => $faker->text
    ];
});


$factory->define(App\Entities\Kelas::class, function(Faker\Generator $faker) {
    return [
        'nama' => $faker->name,
        'keterangan' => $faker->text,
        'jurusan_id' => function(){
            return factory(App\Entities\Jurusan::class)->create()->id;
        }
    ];
});

$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'nis' => $faker->randomNumber(8),
        'nisn' => $faker->randomNumber,
        'no_ujian' => $faker->unique()->randomNumber(7),
        'password' => $password ?: $password = bcrypt('secret'),
        'password_text' => 'secret',
        'remember_token' => str_random(10),
        'kelas_id' => function () {
            return factory(App\Entities\Kelas::class)->create()->id;
        }
    ];
});


