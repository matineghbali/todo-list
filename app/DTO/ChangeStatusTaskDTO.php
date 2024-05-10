<?php

namespace App\DTO;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class ChangeStatusTaskDTO
 *
 * @property-read string|null $status
 *
 * @package App\DTO
 */
class ChangeStatusTaskDTO implements FromRequestDTOInterface
{
    /**
     * ChangeStatusTaskDTO constructor.
     *
     * @param string|null $status
     */
    public function __construct(
        public ?string $status = null
    ) {
    }

    /**
     * @param FormRequest $request
     *
     * @return FromRequestDTOInterface
     */
    public function fromRequest(FormRequest $request): FromRequestDTOInterface
    {
        return new self(
            status: $request->input('status')
        );
    }
}
