<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\ModelDocument;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateModelDocumentAPIRequest extends AppBaseFormRequest
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
        'document_generation_template_id' => 'required',
        'model_primary_id' => 'required',
        'model_type_name' => 'required',
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
    *     title="model_primary_id",
    *     description="model_primary_id",
    *     type="string"
    * )
    */
    public $model_primary_id;

    /**
    * @OA\Property(
    *     title="model_type_name",
    *     description="model_type_name",
    *     type="string"
    * )
    */
    public $model_type_name;

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
