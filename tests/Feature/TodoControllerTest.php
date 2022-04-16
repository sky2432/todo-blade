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
     * Test getting only completed todo.
     *
     * @return void
     */
    public function test_get_only_completed_todo()
    {
        Todo::factory()->create([
            'is_completed' => true
        ]);

        $response = $this->get('/todo')->assertStatus(200);
        $this->assertEmpty($response['todos']);
    }

    /**
     * Test getting incomplete todo.
     *
     * @return void
     */
    public function test_get_incomplete_todo()
    {
        Todo::factory()->create([
            'name' => '勉強',
            'is_completed' => false,
        ]);
        Todo::factory()->create([
            'name' => '買い物',
            'is_completed' => false,
        ]);

        $this
            ->get('/todo')
            ->assertStatus(200)
            ->assertSee('勉強')
            ->assertSee('買い物');
    }

    /**
     * Test storing todo fail.
     *
     * @return void
     */
    public function test_store_fail()
    {
        $this
            ->post('/todo', ['name' => ''])
            ->assertSessionHasErrors(['name']);
    }

    /**
     * Test storing todo success.
     *
     * @return void
     */
    public function test_store_success()
    {
        $this
            ->post('/todo', ['name' => '勉強'])
            ->assertSessionHasNoErrors()
            ->assertRedirect('todo');

        $this->assertDatabaseHas('todos', [
            'name' => '勉強'
        ]);
    }

    /**
     * Test updating todo fail.
     *
     * @return void
     */
    public function test_update_fail()
    {
        $todo = Todo::factory()->create([
            'name' => '勉強'
        ]);

        $this
            ->put("/todo/{$todo->id}", ['name' => ''])
            ->assertSessionHasErrors(['name']);
    }

    /**
     * Test updating todo success.
     *
     * @return void
     */
    public function test_update_success()
    {
        $todo = Todo::factory()->create([
            'name' => '勉強'
        ]);

        $this
            ->put("/todo/{$todo->id}", ['name' => '学習'])
            ->assertSessionHasNoErrors()
            ->assertRedirect('todo');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'name' => '学習'
        ]);
    }

    /**
     * Test completing todo.
     *
     * @return void
     */
    public function test_complete()
    {
        $todo = Todo::factory()->create([
            'is_completed' => false,
        ]);

        $this
            ->put("/todo/{$todo->id}/complete")
            ->assertRedirect('todo');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'is_completed' => true,
        ]);
    }

    /**
     * Test deleting todo.
     *
     * @return void
     */
    public function test_delete()
    {
        $todo = Todo::factory()->create();

        $this->assertModelExists($todo);

        $this
            ->delete("/todo/{$todo->id}")
            ->assertRedirect('todo');

        $this->assertModelMissing($todo);
    }
}
