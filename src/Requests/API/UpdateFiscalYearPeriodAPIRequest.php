<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\FiscalYearPeriod;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateFiscalYearPeriodAPIRequest extends AppBaseFormRequest
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
        'display_ordinal' => 'nullable|min:0|max:365',
        'name' => 'required|min:4|max:150',
        'status' => 'nullable|min:4|max:150',
        'fiscal_year_id' => 'required',
        'start_date' => 'date',
        'end_date' => 'date'
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
    *     title="display_ordinal",
    *     description="display_ordinal",
    *     type="integer"
    * )
    */
    public $display_ordinal;

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
    *     title="status",
    *     description="status",
    *     type="string"
    * )
    */
    public $status;

    /**
    * @OA\Property(
    *     title="fiscal_year_id",
    *     description="fiscal_year_id",
    *     type="string"
    * )
    */
    public $fiscal_year_id;

    /**
    * @OA\Property(
    *     title="start_date",
    *     description="start_date",
    *     type="string"
    * )
    */
    public $start_date;

    /**
    * @OA\Property(
    *     title="end_date",
    *     description="end_date",
    *     type="string"
    * )
    */
    public $end_date;


}