<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\Batch;

class UpdateSignatureRequest extends AppBaseFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'organization_id' => 'required',
            'staff_name' => 'nullable|max:200',
            'staff_title' => 'max:200',
            'on_behalf' => 'max:200',
            'owner_user_id' => 'required'
        ];
    }
}
