<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class UpdateAnnouncementAPIRequest extends AppBaseFormRequest
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
            'organization_id' => 'nullable',
            'headline' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'content' => 'nullable|max:200',          
            'creator_user_id' => 'nullable|exists:fc_users,id',
        ];
    }
}
