<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories\Contracts
 */
interface BaseRepositoryInterface
{
    public function all();

    public function paginate($limit = 15);

    public function getBy($col, $value, $limit = 15);

    public function create(array $data);

    public function find($id);

    public function update($model, array $data);

    public function changeStatus($model, $status);

    public function delete($model);

    public function exists($id);
}
