<?php
 
use Faker\Generator as Faker;
use App\Author;

$factory->define('App\Artical', function (Faker $faker) {
    return [
         'main_title'=>$faker->sentence(),
         'secondary_title'=>$faker->sentence(), 
         'content'=>$faker->text(),
         'image'=>$faker->image(),
         'author_id' => Author::all()->random()->id,
      
    ];
});