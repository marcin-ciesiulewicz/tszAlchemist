<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class UpdateCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('is-admin'), Response::HTTP_FORBIDDEN, '403 Access denied');

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
            'status' => 'required|integer',
            'cycle' => 'required|integer|between:1,3',
            'description'=>'string|nullable',
            'teamwork_id'=>'nullable|integer',
            'manager_seo_id' => 'exists:App\Models\User,id|required|integer',
            'manager_technical_id' => 'exists:App\Models\User,id|required|integer',
            'package_id'=>'exists:App\Models\Package,id|nullable|integer'
        ];
    }
}
