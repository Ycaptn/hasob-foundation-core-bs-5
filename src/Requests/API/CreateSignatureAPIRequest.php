<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\Batch;

class CreateSignatureAPIRequest extends AppBaseFormRequest
{

    public function authorize()
    {
        return true;
    }


    public function messages(){
        return [
            'owner_user_id.unique' => 'This user signature already exists',
            'owner_user_id.required' => 'Please select a user'
        ];
    }

    public function rules()
    {
        return [
            'organization_id' => 'required',
            'staff_name' => 'nullable|max:200',
            'staff_title' => 'max:200',
            'on_behalf' => 'max:200',
            'signature_image' => 'required|mimes:jpeg,jpg',
            'owner_user_id' => 'required|unique:fc_signatures,owner_user_id'
        ];
    }
}
