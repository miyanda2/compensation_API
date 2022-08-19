<?php

namespace Database\Factories;

use App\Models\Compensation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompensationFactory extends Factory
{
    protected $model = Compensation::class;

    public function definition(): array
    {
    	return [
    	    'age' => Str::random(2),
            'industry' => $this->faker->name(),
            'role' => $this->faker->numberBetween(1, 50),
            'annualSalary' => $this->faker->numberBetween(1, 50),
            'currencyType' => $this->faker->name(),
            'loc' => $this->faker->name(),
            'yearOfExperince' => $this->faker->name(),
            'additionalContents' => $this->faker->sentence(),
            'other' => Str::random(8),
    	];
    }
}
