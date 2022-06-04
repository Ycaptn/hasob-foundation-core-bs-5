<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\DisabledItem;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateDisabledItemAPIRequest extends AppBaseFormRequest
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
        'disable_id' => 'nullable',
        'disable_type' => 'nullable',
        'disable_reason' => 'nullable|max:500',
        'disabling_user_id' => 'nullable',
        'wf_status' => 'max:100',
        'wf_meta_data' => 'max:1000'
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
    *     title="disable_id",
    *     description="disable_id",
    *     type="string"
    * )
    */
    public $disable_id;

    /**
    * @OA\Property(
    *     title="disable_type",
    *     description="disable_type",
    *     type="string"
    * )
    */
    public $disable_type;

    /**
    * @OA\Property(
    *     title="is_disabled",
    *     description="is_disabled",
    *     type="boolean"
    * )
    */
    public $is_disabled;

    /**
    * @OA\Property(
    *     title="disable_reason",
    *     description="disable_reason",
    *     type="string"
    * )
    */
    public $disable_reason;

    /**
    * @OA\Property(
    *     title="disabled_at",
    *     description="disabled_at",
    *     type="string"
    * )
    */
    public $disabled_at;

    /**
    * @OA\Property(
    *     title="disabling_user_id",
    *     description="disabling_user_id",
    *     type="string"
    * )
    */
    public $disabling_user_id;

    /**
    * @OA\Property(
    *     title="wf_status",
    *     description="wf_status",
    *     type="string"
    * )
    */
    public $wf_status;

    /**
    * @OA\Property(
    *     title="wf_meta_data",
    *     description="wf_meta_data",
    *     type="string"
    * )
    */
    public $wf_meta_data;


}
