<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Family;
use App\Models\Projection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectionAmount>
 */
class ProjectionAmountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'projection_id' => Projection::inRandomOrder()->first()->id,
            'branchid' => Branch::inRandomOrder()->first()->BranchId,
            'familyid' => Family::inRandomOrder()->first()->FamilyId,
            'new_sale' => fake()->randomFloat(2,100000,10000000),
            'old_sale' => fake()->randomFloat(2,100000,10000000),
            'purchase' => fake()->randomFloat(2,100000,1000000),
        ];
    }
}
