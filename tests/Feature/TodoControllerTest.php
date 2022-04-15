<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getting todo.
     *
     * @return void
     */
    public function test_get()
    {
        Todo::factory()->create([
            'is_completed' => true
        ]);

        // complete todo
        $response = $this->get('/todo')->assertStatus(200);
        $this->assertEmpty($response['todos']);

        Todo::factory()->create([
            'name' => '勉強',
            'is_completed' => false,
        ]);
        Todo::factory()->create([
            'name' => '買い物',
            'is_completed' => false,
        ]);

        // incomplete todo
        $this
            ->get('/todo')
            ->assertStatus(200)
            ->assertSee('勉強')
            ->assertSee('買い物');
    }
}
