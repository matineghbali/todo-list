<?php

namespace App\DTO\Contracts;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface ToArrayDTOInterface
 *
 * @package App\DTO\Contracts
 */
interface ToArrayDTOInterface
{
    /**
     * @param Model|null $model
     *
     * @return array
     */
    public function toArray(?Model $model = null): array;
}
