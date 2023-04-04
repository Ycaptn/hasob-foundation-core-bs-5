<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Address;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateCommentAPIRequest extends AppBaseFormRequest
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
            'content' => 'required|string|max:1000',
            'commentable_id' => 'required|uuid',
            'commentable_type' => "required|string|in:workItem",
        ];
    }

}
