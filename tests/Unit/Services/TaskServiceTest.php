<?php

namespace Tests\Unit\Services;

use App\Models\User;
use Tests\TestCase;
use App\Models\Task;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Services\TaskService;
use App\DTO\ChangeStatusTaskDTO;

/**
 * Class TaskServiceTest
 *
 * @package Tests\Unit\Services
 */
class TaskServiceTest extends TestCase
{

    public function test_can_create_task_in_service_layer(): void
    {
        $dto = new CreateTaskDTO(
            title: fake()->word,
            description: fake()->text,
            user_ids: [User::factory()->create()],
        );

        $task = $this->app->make(TaskService::class)
            ->createTask($dto);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', [
            'status' => Task::TODO_STATUS,
            'title' => $dto->title,
            'description' => $dto->description,
        ]);
        $this->assertDatabaseHas('task_user', [
            'user_id' => $dto->user_ids[0]
        ]);
    }

    public function test_can_update_task_in_service_layer()
    {
        $task = Task::factory()
            ->create();
        $dto = new UpdateTaskDTO(
            status: fake()->randomElements(Task::ALL_STATUSES),
            title: fake()->word,
            description: fake()->text,
            user_ids: [User::factory()->create()],
        );

        $responseTask = app()->make(TaskService::class)->updateTask($task, $dto);

        $this->assertInstanceOf(Task::class, $responseTask);
        $this->assertDatabaseHas($task->getTable(), [
            'id' => $task->id,
            'status' => $dto->status,
            'title' => $dto->title,
            'description' => $dto->description,
            'creator_id' => $task->creator_id,
        ]);
        $this->assertDatabaseHas('task_user', [
            'user_id' => $dto->user_ids[0]
        ]);
    }

    public function test_can_change_status_task_in_service_layer()
    {
        $task = Task::factory()
            ->create([
                'status' => fake()->randomElements(Task::ALL_STATUSES),
            ]);
        $dto = new ChangeStatusTaskDTO(
            status: fake()->randomElements(Task::ALL_STATUSES),
        );

        $response = app()->make(TaskService::class)
            ->changeStatus($task, $dto);

        $this->assertInstanceOf(Task::class, $response);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => $dto->status,
        ]);
    }

    public function test_can_delete_tasks_in_service_layer()
    {
        $task = Task::factory()
            ->create();

        app()->make(TaskService::class)->delete($task);

        $this->assertDatabaseMissing($task->getTable(), [
            'id' => $task->id,
        ]);
        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id
        ]);
    }
}
