<?php

namespace App\Services;

use Exception;
use App\Models\Task;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use Illuminate\Http\Request;
use App\DTO\ChangeStatusTaskDTO;
use App\Http\Resources\TaskResource;
use App\Services\Contracts\BaseService;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class TaskService
 *
 * @package App\Services
 */
class TaskService extends BaseService
{
    /**
     * TaskService constructor.
     *
     * @param TaskRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(TaskRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function getList(Request $request): AnonymousResourceCollection
    {
        if ($request->has('status')) {
           $tasks = $this->repository->getBy('status', $request->input('status'));
        }
        $tasks = $this->repository->all();

        return TaskResource::collection($tasks);
    }

    /**
     * @param CreateTaskDTO $dto
     *
     * @return Task
     *
     * @throws Exception
     */
    public function createTask(CreateTaskDTO $dto): Task
    {
        $task = $this->repository->create($dto->toArray());
        $task->users()->sync($dto->user_ids);

        return $task;
    }

    /**
     * @param Task $task
     * @param UpdateTaskDTO $dto
     *
     * @return Task
     *
     * @throws Exception
     */
    public function updateTask(Task $task, UpdateTaskDTO $dto): Task
    {
        $this->repository->update($task, $dto->toArray($task));
        $task->users()->sync($dto->user_ids);

        return $task;
    }

    /**
     * @param Task $task
     * @param ChangeStatusTaskDTO $dto
     *
     * @return Task
     */
    public function changeStatus(Task $task, ChangeStatusTaskDTO $dto): Task
    {
        $this->repository->changeStatus($task, $dto->status);

        return $task;
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    public function delete(Task $task): void
    {
        $this->repository->delete($task);
    }
}
