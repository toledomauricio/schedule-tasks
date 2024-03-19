<?php

// database/factories/ScheduleFactory.php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'due_date' => $this->faker->dateTimeBetween('now', '+2 month'),
            'status' => $this->faker->randomElement(['open', 'completed']),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
