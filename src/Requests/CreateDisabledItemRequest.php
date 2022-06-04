<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\DisabledItem;

class CreateDisabledItemRequest extends AppBaseFormRequest
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
            'organization_id' => 'required',
        'disable_id' => 'nullable',
        'disable_type' => 'nullable',
        'disable_reason' => 'nullable|max:500',
        'disabling_user_id' => 'nullable',
        'wf_status' => 'max:100',
        'wf_meta_data' => 'max:1000'
        ];
    }
}
