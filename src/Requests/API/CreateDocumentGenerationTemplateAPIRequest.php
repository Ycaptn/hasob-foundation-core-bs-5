<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\DocumentGenerationTemplate;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateDocumentGenerationTemplateAPIRequest extends AppBaseFormRequest
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
            'display_ordinal' => 'nullable|min:0|max:365',
            'title' => 'required|min:4|max:150',
            'content' => 'nullable|min:0|max:65500',
            'output_content_types' => 'nullable|max:150',
            'file_name_prefix' => 'nullable|max:150',
            'document_layout' => 'nullable|max:150',
            'creator_user_id' => 'nullable'
        ];
    }

}
