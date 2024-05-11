<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\DTO\ChangeStatusTaskDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TaskResource;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\ChangeStatusTaskRequest;

/**
 * Class TaskController
 *
 * @package App\Http\Controllers\Api\V1\Private
 */
class TaskController extends Controller
{
    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(private TaskService $taskService)
    {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(
            trans('messages.successfully'),
            (array)$this->taskService->getList($request)
        ,200);
    }

    /**
     * @param CreateTaskRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateTaskRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(CreateTaskDTO::class)->fromRequest($request);
            $this->taskService->createTask($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param Task $task
     *
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return $this->successResponse(
            trans('messages.successfully'),
            (array)$this->taskService->getView($task, TaskResource::class)
        );
    }

    /**
     * @param Task $task
     * @param UpdateTaskRequest $request
     *
     * @return JsonResponse
     */
    public function update(Task $task, UpdateTaskRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(UpdateTaskDTO::class)->fromRequest($request);
            $this->taskService->updateTask($task, $dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param Task $task
     * @param ChangeStatusTaskRequest $request
     *
     * @return JsonResponse
     */
    public function changeStatus(Task $task, ChangeStatusTaskRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(ChangeStatusTaskDTO::class)->fromRequest($request);
            $this->taskService->changeStatus($task, $dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully'),
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * @param Task $task
     *
     * @return JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->taskService->delete($task);
            DB::commit();

            return $this->successResponse(
                trans('messages.successfully')
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
