<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\Address;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class AttachmentRenameAPIRequest extends AppBaseFormRequest
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
            'name' => 'required',
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
    *     title="is_preferred",
    *     description="is_preferred",
    *     type="boolean"
    * )
    */
    public $is_preferred;

    /**
    * @OA\Property(
    *     title="label",
    *     description="label",
    *     type="string"
    * )
    */
    public $label;

    /**
    * @OA\Property(
    *     title="contact_person",
    *     description="contact_person",
    *     type="string"
    * )
    */
    public $contact_person;

    /**
    * @OA\Property(
    *     title="street",
    *     description="street",
    *     type="string"
    * )
    */
    public $street;

    /**
    * @OA\Property(
    *     title="town",
    *     description="town",
    *     type="string"
    * )
    */
    public $town;

    /**
    * @OA\Property(
    *     title="state",
    *     description="state",
    *     type="string"
    * )
    */
    public $state;

    /**
    * @OA\Property(
    *     title="country",
    *     description="country",
    *     type="string"
    * )
    */
    public $country;

    /**
    * @OA\Property(
    *     title="telephone",
    *     description="telephone",
    *     type="string"
    * )
    */
    public $telephone;

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

    /**
    * @OA\Property(
    *     title="addressable_id",
    *     description="addressable_id",
    *     type="string"
    * )
    */
    public $addressable_id;

    /**
    * @OA\Property(
    *     title="addressable_type",
    *     description="addressable_type",
    *     type="string"
    * )
    */
    public $addressable_type;


}
