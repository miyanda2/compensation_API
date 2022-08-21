<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
    	return [
    	    'firstName' => $this->faker->name(),
            'lastName' => $this->faker->name(),
            'email' => $this->faker->email(),
            'eId' => Str::random(5),
            
    	];
    }
}
