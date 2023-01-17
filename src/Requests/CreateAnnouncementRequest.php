<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class CreateAnnouncementRequest extends AppBaseFormRequest
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
            'headline' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
            'content' => 'nullable|max:200',          
            'creator_user_id' => 'required|exists:fc_users,id',
        ];
    }
}
