<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

/**
 * Class TaskTest
 *
 * @package Tests\Feature
 */
final class TaskTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_get_tasks_list(): void
    {
        Task::factory()
            ->create();

        $response = $this->actingAs(User::factory()->create())->get(
            route('tasks.index')
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
    }

    public function test_can_create_task_web_service(): void
    {
        $payload = [
            'title' => fake()->word,
            'description' => fake()->text,
            'user_ids' => [User::factory()->create()->id],
        ];

        $response = $this->actingAs(User::factory()->create())->post(
            route('tasks.store'),
            $payload
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
        $this->assertDatabaseHas('tasks', [
            'status' => Task::TODO_STATUS,
            'title' => $payload['title'],
            'description' => $payload['description'],
        ]);
        $this->assertDatabaseHas('task_user', [
            'user_id' => $payload['user_ids'][0]
        ]);
    }

    public function test_can_view_tasks_web_service(): void
    {
        $task = Task::factory()
            ->create();

        $response = $this->actingAs(User::factory()->create())->get(
            route('tasks.show', ['task' => $task]),
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
    }

    public function test_can_update_task_web_service(): void
    {
        $task = Task::factory()
            ->create();
        $payload = [
            'status' => fake()->randomElement(Task::ALL_STATUSES),
            'title' => fake()->word,
            'description' => fake()->text,
            'user_ids' => [User::factory()->create()->id],
        ];

        $response = $this->actingAs(User::factory()->create())->put(
            route('tasks.update', ['task' => $task]),
            $payload
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
        $this->assertDatabaseHas($task->getTable(), [
            'id' => $task->id,
            'status' => $payload['status'],
            'title' => $payload['title'],
            'description' => $payload['description'],
            'creator_id' => $task->creator_id,
        ]);
        $this->assertDatabaseHas('task_user', [
            'user_id' => $payload['user_ids'][0]
        ]);
    }

    public function test_can_change_task_status_web_service(): void
    {
        $task = Task::factory()
            ->create([
                'status' => fake()->randomElement(Task::ALL_STATUSES),
            ]);
        $payload = [
            'status' => fake()->randomElement(Task::ALL_STATUSES),
        ];

        $response = $this->actingAs(User::factory()->create())->put(
            route('tasks.status', ['task' => $task]),
            $payload
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => $payload['status'],
        ]);
    }

    public function test_can_delete_task_web_service(): void
    {
        $task = Task::factory()
            ->create();

        $response = $this->actingAs(User::factory()->create())->delete(
            route('tasks.destroy', ['task' => $task]),
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
        $this->assertSoftDeleted($task->getTable(), [
            'id' => $task->id,
        ]);
        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id
        ]);
    }
}
