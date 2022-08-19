<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
    	return [
    	    'employee_id' => Str::random(2),
            'date' => $this->faker->name(),
            'hours' => $this->faker->numberBetween(1, 50),
            'breakTime' => $this->faker->numberBetween(1, 50),
            'in' => $this->faker->name(),
            'out' => $this->faker->name(),
            'locAddress' => $this->faker->name(),
            'image' => $this->faker->sentence(),
            'map' => Str::random(8),
    	];
    }
}
