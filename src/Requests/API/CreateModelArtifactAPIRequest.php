<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\ModelArtifact;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateModelArtifactAPIRequest extends AppBaseFormRequest
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
        'model_primary_id' => 'required',
        'model_name' => 'required',
        'key' => 'required|max:200',
        'value' => 'nullable|max:2000',
        'binary_value' => 'nullable',
        'invocation_id' => 'nullable',
        'invocation_controller_class' => 'nullable',
        'invocation_controller_method' => 'nullable',
        'invocation_route_name' => 'nullable'
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
    *     title="model_primary_id",
    *     description="model_primary_id",
    *     type="string"
    * )
    */
    public $model_primary_id;

    /**
    * @OA\Property(
    *     title="model_name",
    *     description="model_name",
    *     type="string"
    * )
    */
    public $model_name;

    /**
    * @OA\Property(
    *     title="key",
    *     description="key",
    *     type="string"
    * )
    */
    public $key;

    /**
    * @OA\Property(
    *     title="value",
    *     description="value",
    *     type="string"
    * )
    */
    public $value;

    /**
    * @OA\Property(
    *     title="binary_value",
    *     description="binary_value",
    *     type="string"
    * )
    */
    public $binary_value;

    /**
    * @OA\Property(
    *     title="invocation_id",
    *     description="invocation_id",
    *     type="string"
    * )
    */
    public $invocation_id;

    /**
    * @OA\Property(
    *     title="invocation_controller_class",
    *     description="invocation_controller_class",
    *     type="string"
    * )
    */
    public $invocation_controller_class;

    /**
    * @OA\Property(
    *     title="invocation_controller_method",
    *     description="invocation_controller_method",
    *     type="string"
    * )
    */
    public $invocation_controller_method;

    /**
    * @OA\Property(
    *     title="invocation_route_name",
    *     description="invocation_route_name",
    *     type="string"
    * )
    */
    public $invocation_route_name;


}
