<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class UpdateSupportAPIRequest extends AppBaseFormRequest
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
            'location' => 'required',
            'support_type' => 'nullable|max:200',
            'issue_type' => 'nullable|max:200',
            'designation_department_id' => 'nullable|exists:fc_departments,id',
            'severity' => 'required',
            'description' => 'required',
            'creator_user_id' => 'nullable|exists:fc_users,id',
            'designated-user_id' => 'nullable|exists:fc_users,id',

        ];
    }
}
