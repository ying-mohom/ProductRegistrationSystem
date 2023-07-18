<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Item::class, function (Faker $faker) {
    static $id=10000;
    static $code=20000;
    //Get Minimum Id and Maximum Id
    $minCategoryId = DB::table('categories')->min('id');
    $maxCategoryId = DB::table('categories')->max('id');

    return [
        'item_id' => ++$id,
        'item_code'=> ++$code,
        'item_name'=> $faker->word(),
        'category_id' =>$faker->numberBetween($minCategoryId, $maxCategoryId),
        'safety_stock'=>$faker->numberBetween(100,500),
        'received_date'=>$faker->date(),
        'description'=>$faker->title(),

    ];
});
