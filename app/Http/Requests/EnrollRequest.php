<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollRequest extends FormRequest
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
            'receiver_id' => [
                'required',
                'numeric',
                Rule::exists('users', 'id')->whereNot('id', auth()->id())
            ],
            'amount' => 'required|numeric|min:1|max:' . auth()->user()->balance,
            'date_time' => 'required|date|after:' . now(),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'after' => 'Указанные дата и время уже прошли.',
        ];
    }
}
