<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'roll_no' => $this->faker->unique()->numerify('S###'),
            'enrollment_year' => $this->faker->year(),
            'program' => $this->faker->randomElement(['BSc','BCom','BTech']),
            'class' => $this->faker->randomElement(['FY','SY','TY']),
            'meta' => [],
        ];
    }
}
