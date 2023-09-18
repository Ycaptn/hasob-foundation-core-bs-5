<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Reaction;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateReactionAPIRequest extends AppBaseFormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'organization_id' => 'nullable',
            'status' => 'nullable|max:100',
            'reactionable_id' => 'required|max:150',
            'reactionable_type' => 'required|max:150',
            'comments' => 'nullable|max:150',
            'creator_user_id' => 'nullable'
        ];
    }



}
