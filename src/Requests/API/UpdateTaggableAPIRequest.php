<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Taggable;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateTaggableAPIRequest extends AppBaseFormRequest
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
            'taggable_id' => 'nullable',
        'taggable_type' => 'nullable',
        'tag_id' => 'nullable',
        'user_id' => 'nullable'
        ];
    }

    /**
    * @OA\Property(
    *     title="taggable_id",
    *     description="taggable_id",
    *     type="string"
    * )
    */
    public $taggable_id;

    /**
    * @OA\Property(
    *     title="taggable_type",
    *     description="taggable_type",
    *     type="string"
    * )
    */
    public $taggable_type;

    /**
    * @OA\Property(
    *     title="tag_id",
    *     description="tag_id",
    *     type="string"
    * )
    */
    public $tag_id;

    /**
    * @OA\Property(
    *     title="user_id",
    *     description="user_id",
    *     type="string"
    * )
    */
    public $user_id;


}
