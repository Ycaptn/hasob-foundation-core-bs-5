<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Page;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdatePageAPIRequest extends AppBaseFormRequest
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
            'display_ordinal' => 'nullable|min:0|max:365',
            'page_name' => 'nullable|min:4|max:150',
            'page_path' => 'nullable|min:4|max:150',
            'content' => 'nullable|min:0|max:10000',
            'blade_file_path' => 'nullable|max:150',
            'external_page_key' => 'nullable|max:150',
            'external_page_url' => 'nullable|max:150',
            'view_allowed_roles' => 'nullable|max:2000',
            'view_allowed_user_ids' => 'nullable|max:2000',
            'site_id' => 'nullable',
            'creator_user_id' => 'nullable'
        ];
    }

}
