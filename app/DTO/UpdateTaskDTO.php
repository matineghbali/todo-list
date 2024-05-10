<?php

namespace App\DTO;

use Exception;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

/**
 * Class CreateTaskDTO
 *
 * @property-read string|null $status
 * @property-read string|null $title
 * @property-read string|null $description
 * @property-read array|null $user_ids
 *
 * @package App\DTO\Private
 */
class UpdateTaskDTO implements FromRequestDTOInterface, ToArrayDTOInterface
{
    /**
     * CreateTaskDTO constructor.
     *
     * @param string|null $status
     * @param string|null $title
     * @param string|null $description
     * @param array|null $user_ids
     */
    public function __construct(
        public ?string $status = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?array $user_ids = null,
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
            status: $request->input('status'),
            title: $request->input('title'),
            description: $request->input('description'),
            user_ids: $request->input('user_ids')
        );
    }

    /**
     * @param Task|Model|null $model
     *
     * @return array
     *
     * @throws Exception
     */
    public function toArray(?Model $model = null): array
    {
        return [
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
