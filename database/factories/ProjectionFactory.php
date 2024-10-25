<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projection>
 */
class ProjectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('now','+4 years');
        $end_date = fake()->dateTimeBetween($start_date, (clone $start_date)->modify('+8 months'));
        return [
            'name' => fake()->regexify('[A-Z]{3}[0-9]{3}'),
            'start' => $start_date,
            'end' => $end_date,
        ];
    }
}
