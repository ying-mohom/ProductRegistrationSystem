<?php

use App\Model\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the employee seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class,5)->create();
    }
}
