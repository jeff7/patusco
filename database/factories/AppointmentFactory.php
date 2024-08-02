<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'animal_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'animal_type' => $this->faker->randomElement(['C','D', 'F', 'B']),
            'period' => $this->faker->randomElement(['M','T']),
            'age' => $this->faker->numberBetween(18, 65),
            'user_id' => $this->faker->numberBetween(1,10),
            'symptoms' => $this->faker->text(255),
            'appointment_date' => $this->faker->dateTime,
        ];
    }
}
