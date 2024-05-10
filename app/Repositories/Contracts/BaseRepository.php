<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class BaseRepository
 *
 * @package App\Repositories\Contracts
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model|Builder
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    public function paginate($limit = 15)
    {
        return $this->model->orderBy('id', 'desc')->paginate($limit);
    }

    public function getBy($col, $value, $limit = 15)
    {
        return $this->model->where($col, $value)->limit($limit)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($model, array $data)
    {
        return $model->update($data);
    }

    public function changeStatus($model, $status)
    {
        return $model->update([
            'status' => $status
        ]);
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }
}
