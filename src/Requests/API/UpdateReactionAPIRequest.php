<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Reaction;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateReactionAPIRequest extends AppBaseFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'organization_id' => 'nullable',
            'status' => 'max:100',
            'reactionable_id' => 'nullable|max:150',
            'reactionable_type' => 'nullable|max:150',
            'comments' => 'nullable|max:150',
            'creator_user_id' => 'nullable'
        ];
    }

}
