<?php
 
use Faker\Generator as Faker;
 
$factory->define('App\Author', function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'email'=>$faker->email,
        'password'=>app('hash')->make('12345'),
        'github'=>$faker->email,
        'twitter'=>$faker->email,
        'location'=>$faker->email
    ];
});