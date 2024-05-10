<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangeStatusTaskRequest
 *
 * @package App\Http\Requests\Private
 */
class ChangeStatusTaskRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Task::ALL_STATUSES)],
        ];
    }
}
