<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,5),
            'date' => $this->faker->TimeInterval(['-14 days'], ['+5 day'], ['now']),
            'stat_time' => $this->faker->time(['08:00:00'],['10:00:00']),
            'end_time' => $this->faker->time(['16:00:00'], ['19:00:00']),
            ];
    }
}
