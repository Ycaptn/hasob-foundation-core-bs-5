<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\BudgetItem;

class UpdateBudgetItemRequest extends AppBaseFormRequest
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
        /*
        
        */
        return [
            'organization_id' => 'required',
        'title' => 'required|max:200',
        'code' => 'nullable|max:200',
        'group' => 'nullable|max:200',
        'type' => 'nullable|max:200',
        'location' => 'nullable|max:200',
        'description' => 'nullable|max:2000',
        'allocated_amount' => 'required|min:1|max:1000000000000',
        'budget_id' => 'required',
        'status' => 'max:100',
        'wf_status' => 'max:100',
        'wf_meta_data' => 'max:1000',
        'creator_user_id' => 'required'
        ];
    }
}
