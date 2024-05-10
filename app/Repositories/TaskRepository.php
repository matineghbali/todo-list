<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\TaskRepositoryInterface;

/**
 * Class TaskRepository
 *
 * @package App\Repositories
 */
class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor.
     *
     * @param Task $model
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}
