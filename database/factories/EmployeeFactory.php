<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        $date_of_birth = $this->faker->date;
        $age = Carbon::now()->format('Y') - Carbon::parse($date_of_birth)->format('Y');
        return [
            'name' => $this->faker->name,
            'employee_id' => $this->faker->unique()->numberBetween(400000000, 800000000),
            'date_of_birth' => $date_of_birth,
            'age' => $age,
            'gender' => $this->faker->randomElement(['ذكر', 'أنثى']),
            'matrimonial_status' => $this->faker->randomElement(['أعزب','متزوج']),
            'number_wives' => $this->faker->numberBetween(0,4),
            'number_children' => $this->faker->numberBetween(0,10),
            'number_university_children' => $this->faker->numberBetween(0,10),
            'scientific_qualification' => "بكالوريس",
            'specialization' => 'محاسب',
            'university' => 'الأزهر',
            'area' => 'دير البلح',
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->unique()->phoneNumber,
        ];
    }
}
