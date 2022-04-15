<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(50),
            'description' => $this->faker->realText(),
            'due_date' => now()->addMinutes(rand(5, 7200)),
            'status' => Arr::random(['todo', 'done', 'in_progress']),
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => User::where('id', '>=', 4)->inRandomOrder()->first()->id
        ];
    }
}
