<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TodoList>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $todos = [
            '勉強',
            '買い物',
            '掃除',
            '洗濯',
            'ミーティング',
        ];

        return [
            'name' => Arr::random($todos),
            'is_completed' => $this->faker->boolean(),
        ];
    }
}
