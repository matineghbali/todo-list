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
 * @property-read string|null $title
 * @property-read string|null $description
 * @property-read array|null $user_ids
 *
 * @package App\DTO\Private
 */
class CreateTaskDTO implements FromRequestDTOInterface, ToArrayDTOInterface
{
    /**
     * CreateTaskDTO constructor.
     *
     * @param string|null $title
     * @param string|null $description
     * @param array|null $user_ids
     */
    public function __construct(
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
            'status' => Task::TODO_STATUS,
            'title' => $this->title,
            'description' => $this->description,
            'creator_id' => Auth::id(),
        ];
    }
}
