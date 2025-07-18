<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(2),
            'completed' => $this->faker->boolean(20), // 20% completed
            // Make sure user_id is set when calling factory in seeder
        ];
    }
}
