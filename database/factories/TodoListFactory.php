<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodoList>
 */
class TodoListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $todo_lists = [
            '勉強',
            '買い物',
            '掃除',
            '洗濯',
            'ミーティング',
        ];

        return [
            'name' => Arr::random($todo_lists),
            'is_completed' => $this->faker->boolean(),
        ];
    }
}
