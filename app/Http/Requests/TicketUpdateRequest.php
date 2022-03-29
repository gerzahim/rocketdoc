<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
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
            'key'      => ['required', 'max:255', 'string'],
//            'summary'  => ['required', 'max:255', 'string'],
//            'url'      => ['required', 'url'],
            'releases' => ['array'],
        ];
    }
}
