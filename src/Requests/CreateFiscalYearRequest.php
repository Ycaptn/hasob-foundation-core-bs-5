<?php

namespace Hasob\FoundationCore\Requests;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;
use Hasob\FoundationCore\Models\FiscalYear;

class CreateFiscalYearRequest extends AppBaseFormRequest
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
        'display_ordinal' => 'nullable|min:0|max:365',
        'name' => 'required|min:4|max:150',
        'status' => 'nullable|min:4|max:150',
        'creator_user_id' => 'required',
        'start_date' => 'date',
        'end_date' => 'date'
        ];
    }
}
