<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\ModelDocument;

class UpdateModelDocumentRequest extends AppBaseFormRequest
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
        'document_generation_template_id' => 'required',
        'artifactable_id' => 'required',
        'artifactable_type' => 'required',
        'display_ordinal' => 'nullable|min:0|max:365'
        ];
    }
}
