<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Tag;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateTagAPIRequest extends AppBaseFormRequest
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
        'parent_id' => 'nullable',
        'name' => 'required|max:50',
        'meta_data' => 'nullable',
        'user_id' => 'nullable'
        ];
    }

    /**
    * @OA\Property(
    *     title="organization_id",
    *     description="organization_id",
    *     type="string"
    * )
    */
    public $organization_id;

    /**
    * @OA\Property(
    *     title="parent_id",
    *     description="parent_id",
    *     type="string"
    * )
    */
    public $parent_id;

    /**
    * @OA\Property(
    *     title="name",
    *     description="name",
    *     type="string"
    * )
    */
    public $name;

    /**
    * @OA\Property(
    *     title="meta_data",
    *     description="meta_data",
    *     type="string"
    * )
    */
    public $meta_data;

    /**
    * @OA\Property(
    *     title="user_id",
    *     description="user_id",
    *     type="string"
    * )
    */
    public $user_id;


}
