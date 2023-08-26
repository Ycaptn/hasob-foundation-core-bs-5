<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateModelDocumentAPIRequest extends AppBaseFormRequest
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
        'document_generation_template_id' => 'required',
        'artifactable_id' => 'required',
        'artifactable_type' => 'required',
        'display_ordinal' => 'nullable|min:0|max:365'
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
    *     title="document_generation_template_id",
    *     description="document_generation_template_id",
    *     type="string"
    * )
    */
    public $document_generation_template_id;

    /**
    * @OA\Property(
    *     title="artifactable_id",
    *     description="artifactable_id",
    *     type="string"
    * )
    */
    public $artifactable_id;

    /**
    * @OA\Property(
    *     title="artifactable_type",
    *     description="artifactable_type",
    *     type="string"
    * )
    */
    public $artifactable_type;

    /**
    * @OA\Property(
    *     title="display_ordinal",
    *     description="display_ordinal",
    *     type="integer"
    * )
    */
    public $display_ordinal;

    /**
    * @OA\Property(
    *     title="is_default_template",
    *     description="is_default_template",
    *     type="boolean"
    * )
    */
    public $is_default_template;


}
