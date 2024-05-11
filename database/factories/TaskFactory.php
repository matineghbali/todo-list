<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TaskFactory
 *
 * @package Database\Factories
 */
class TaskFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Task::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(Task::ALL_STATUSES),
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'creator_id' => User::factory(),
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date,
        ];
    }
}
