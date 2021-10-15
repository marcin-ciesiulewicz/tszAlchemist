<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'name'=> 'string|max:255|required',
            'notes' => [
                'string',
                'nullable'
            ],
            'status' => 'integer',
            'firstMonth.*.elementAmount' => 'integer|required',
            'firstMonth'=> 'array',
            'secondMonth.*.elementAmount' => 'integer|required',
            'secondMonth.*.packageFrequency' => 'integer|nullable',
            'secondMonth'=> 'array'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstMonth.*.elementAmount.integer' => 'Quantity must be an integer',
            'firstMonth.*.elementAmount.required' => 'Quantity must be an integer',
            'secondMonth.*.elementAmount.integer' => 'Quantity must be an integer',
            'secondMonth.*.packageFrequency.integer' => 'Frequency must be an integer',
            'secondMonth.*.elementAmount.required' => 'Quantity must be an integer',
        ];
    }
}
