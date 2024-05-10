<?php

namespace App\Services\Contracts;

use App\Mediators\Contracts\BaseMediatorInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Interface HasMediatorInterface
 *
 * @package App\Services\Contracts\Warehouse
 */
interface HasMediatorInterface
{
    /**
     * @return BaseMediatorInterface
     *
     * @throws BindingResolutionException
     */
    public function mediatorClass(): BaseMediatorInterface;
}
