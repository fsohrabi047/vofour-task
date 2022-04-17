<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string', 'min:3'],
            'due_date' => ['required', 'date_format:Y-m-d H:i:s'],
            'user_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:todo,in_progress,done'],
        ];
    }
}
