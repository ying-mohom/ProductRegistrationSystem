<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Category;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Category::class, function (Faker $faker) {
    
    return [
       
        'category_name'=> $faker->name(),
       
    ];
});
