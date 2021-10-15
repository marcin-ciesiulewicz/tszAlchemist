<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageElementRequest extends FormRequest
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
            'name' => [
                'string',
                'max:255',
                'required'
            ],
            'status' => [
                'integer',
                'between:1,2'
            ],
            'notes' => [
                'string',
                'nullable'
            ],
            'task_description' => [
                'string',
                'nullable'
            ],
            'element_id' => [
                'exists:App\Models\Element,id',
                'required',
                'integer'
            ],
            'unit_id' => [
                'exists:App\Models\Unit,id',
                'required',
                'integer'
            ],
            'field_type_id' => [
                'exists:App\Models\FieldType,id',
                'required',
                'integer'
            ],
            'teamwork_task_list_id' => [
                'exists:App\Models\TeamworkTaskList,id',
                'required',
                'integer'
            ]
        ];
    }
}
