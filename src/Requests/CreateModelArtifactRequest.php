<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\ModelArtifact;

class CreateModelArtifactRequest extends AppBaseFormRequest
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
        'artifactable_id' => 'required',
        'artifactable_type' => 'required',
        'key' => 'required|max:200',
        'value' => 'nullable|max:2000',
        'binary_value' => 'nullable',
        'invocation_id' => 'nullable',
        'invocation_controller_class' => 'nullable',
        'invocation_controller_method' => 'nullable',
        'invocation_route_name' => 'nullable'
        ];
    }
}
