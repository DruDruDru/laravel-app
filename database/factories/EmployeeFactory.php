<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "firstname" => fake()->firstName(),
            "lastname" => fake()->lastName(),
            "patronymic" => fake()->firstName(),
            "birth_date" => fake()->date(),
            "gender" => fake()->randomElement(["male", "female"]),
            "login" => fake()->userName(),
            "hire_date" => fake()->date(),
            "termination_date" => fake()->date(),
            "salary" => fake()->randomFloat(2, 500, 100000),
        ];
    }
}
