<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'project_id' => ['required', 'exists:projects,id'],
            'document' => ['nullable', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'released_at' => ['required', 'date'],
            'tickets' => ['array'],
        ];
    }
}
