<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCampaignRequest extends FormRequest
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
            'domain' => 'required|string|max:255',
            'cycle' => 'required|integer|between:1,3',
            'description'=>'string|nullable',
            'budget_real' => 'required|numeric',
            'payment_date'=>'required|date_format:Y-m-d',
            'start_date'=>'required|date_format:Y-m-d',
            'teamwork_id'=>'nullable|integer',
            'company_id' => 'exists:App\Models\Company,id|required|integer',
            'manager_seo_id' => 'exists:App\Models\User,id|required|integer',
            'manager_technical_id' => 'exists:App\Models\User,id|required|integer',
            'currency_id' => 'exists:App\Models\Currency,id|required|integer',
            'niche_id' => 'exists:App\Models\Niche,id|required|integer',
            'package_id'=>'exists:App\Models\Package,id|nullable|integer'
        ];
    }
}
