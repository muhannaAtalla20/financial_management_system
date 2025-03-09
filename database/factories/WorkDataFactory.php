<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkData>
 */
class WorkDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'allowance' => rand(0,40),
            'grade' => rand(1,10),
            'grade_allowance_ratio' => rand(1,100),
            'salary_category' => $this->faker->randomNumber(),
            'working_date' => $this->faker->date,
            'date_installation' => $this->faker->date,
            'date_retirement' => $this->faker->date,
            'working_status' => $this->faker->randomElement(['مداوم', 'غير مداوم']),
            'type_appointment' => $this->faker->randomElement(['دوام كامل', 'دوام جزئي']),
            'field_action' => $this->faker->sentence(),
            'government_official' => $this->faker->boolean(),
            'dual_function' => $this->faker->boolean(),
            'state_effectiveness' => $this->faker->randomElement(['نشيط', 'غير نشيط']),
            'years_service' => rand(1,40),
            'nature_work' => $this->faker->sentence(),
            'association' => $this->faker->sentence(),
            'workplace' => $this->faker->sentence(),
            'section' => $this->faker->sentence(),
            'dependence' => $this->faker->sentence(),
            'branch' => $this->faker->sentence(),
            'establishment' => $this->faker->sentence(),
            'foundation_E' => $this->faker->sentence(),
            'payroll_statement' => $this->faker->randomNumber(),
        ];
    }
}
