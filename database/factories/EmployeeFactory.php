<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Employee;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Employee::class, function (Faker $faker) {
    static $employeeId=10000;
    return [
        'emp_id' => ++$employeeId,
        'emp_name'=> $faker->name(),
        'password' => Hash::make("1234ying"),
    ];
});
