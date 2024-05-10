<?php

namespace App\DTO\Contracts;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Interface FromRequestDTOInterface
 *
 * @package App\DTO\Contracts
 */
interface FromRequestDTOInterface
{
    /**
     * @param FormRequest $request
     *
     * @return $this
     */
    public function fromRequest(FormRequest $request): self;
}
