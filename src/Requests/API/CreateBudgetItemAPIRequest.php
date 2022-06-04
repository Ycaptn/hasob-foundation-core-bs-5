<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\BudgetItem;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class CreateBudgetItemAPIRequest extends AppBaseFormRequest
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
        'title' => 'required|max:200',
        'code' => 'nullable|max:200',
        'group' => 'nullable|max:200',
        'type' => 'nullable|max:200',
        'location' => 'nullable|max:200',
        'description' => 'nullable|max:2000',
        'allocated_amount' => 'required|min:1|max:1000000000000',
        'budget_id' => 'required',
        'status' => 'max:100',
        'wf_status' => 'max:100',
        'wf_meta_data' => 'max:1000',
        'creator_user_id' => 'required'
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
    *     title="title",
    *     description="title",
    *     type="string"
    * )
    */
    public $title;

    /**
    * @OA\Property(
    *     title="code",
    *     description="code",
    *     type="string"
    * )
    */
    public $code;

    /**
    * @OA\Property(
    *     title="group",
    *     description="group",
    *     type="string"
    * )
    */
    public $group;

    /**
    * @OA\Property(
    *     title="type",
    *     description="type",
    *     type="string"
    * )
    */
    public $type;

    /**
    * @OA\Property(
    *     title="location",
    *     description="location",
    *     type="string"
    * )
    */
    public $location;

    /**
    * @OA\Property(
    *     title="description",
    *     description="description",
    *     type="string"
    * )
    */
    public $description;

    /**
    * @OA\Property(
    *     title="allocated_amount",
    *     description="allocated_amount",
    *     type="number"
    * )
    */
    public $allocated_amount;

    /**
    * @OA\Property(
    *     title="budget_id",
    *     description="budget_id",
    *     type="string"
    * )
    */
    public $budget_id;

    /**
    * @OA\Property(
    *     title="status",
    *     description="status",
    *     type="string"
    * )
    */
    public $status;

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
    *     title="creator_user_id",
    *     description="creator_user_id",
    *     type="string"
    * )
    */
    public $creator_user_id;


}
