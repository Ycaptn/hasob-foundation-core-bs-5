<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\Reaction;

class CreateReactionRequest extends AppBaseFormRequest
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
        'status' => 'max:100',
        'reactionable_id' => 'nullable|max:150',
        'reactionable_type' => 'nullable|max:150',
        'status' => 'max:100',
        'comments' => 'nullable|max:150',
        'creator_user_id' => 'required'
        ];
    }
}
