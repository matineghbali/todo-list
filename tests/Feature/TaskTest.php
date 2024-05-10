<?php

namespace Tests\Feature;

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
    public function test_can_get_tasks_list(): void
    {
        Task::factory()
            ->create();

        $response = $this->get(
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
            'user_ids' => [User::factory()->create()],
        ];

        $response = $this->post(
            route('tasks.create'),
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

        $response = $this->get(
            route('tasks.view', ['task' => $task]),
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
    }

    public function test_can_update_task_web_service(): void
    {
        $task = Task::factory()
            ->create();
        $payload = [
            'status' => fake()->randomElements(Task::ALL_STATUSES),
            'title' => fake()->word,
            'description' => fake()->text,
            'user_ids' => [User::factory()->create()],
        ];

        $response = $this->put(
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
                'status' => fake()->randomElements(Task::ALL_STATUSES),
            ]);
        $payload = [
            'status' => fake()->randomElements(Task::ALL_STATUSES),
        ];

        $response = $this->put(
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

        $response = $this->delete(
            route('tasks.delete', ['task' => $task]),
        );

        $response->assertOk();
        $this->assertEquals(trans('messages.successfully'), $response['message']);
        $this->assertDatabaseMissing($task->getTable(), [
            'id' => $task->id,
        ]);
        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id
        ]);
    }
}
