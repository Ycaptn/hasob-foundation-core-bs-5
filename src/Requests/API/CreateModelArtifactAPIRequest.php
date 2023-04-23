<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\ModelArtifact;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateModelArtifactAPIRequest extends AppBaseFormRequest
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
            'model_primary_id' => 'required',
            'model_name' => 'required',
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
