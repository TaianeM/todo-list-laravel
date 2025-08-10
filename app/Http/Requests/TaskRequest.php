<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
           return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status'      => ['required', Rule::in(array_column(TaskStatus::cases(), 'value'))],
            'due_date'    => ['nullable', 'date'],
            'user_id'     => ['required', 'exists:users,id'],
        ];
    }
}