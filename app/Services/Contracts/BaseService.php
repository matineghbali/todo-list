<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseService
 *
 * @package App\Services\Contracts
 */
abstract class BaseService implements BaseServiceInterface
{
    /** @var BaseRepositoryInterface $repository */
    protected BaseRepositoryInterface $repository;

    /**
     * BaseService constructor.
     *
     * @param BaseRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
        if ($this instanceof HasMediatorInterface) {
            $this->mediator = $this->mediatorClass();
        }
    }

    /**
     * @param Model $model
     * @param string $resourceNameSpace
     *
     * @return JsonResource
     */
    public function getView(Model $model, string $resourceNameSpace): JsonResource
    {
        return new $resourceNameSpace($model);
    }
}
