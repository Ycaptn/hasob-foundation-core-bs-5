<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\BatchItem;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class UpdateBatchItemAPIRequest extends AppBaseFormRequest
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
            'status' => 'max:100',
            'wf_status' => 'max:100',
            'wf_meta_data' => 'max:1000',
            'batchable_id' => 'required|max:150',
            'batchable_type' => 'required|max:150',
            'batch_id' => 'required|exists:fc_batches,id',
        ];
    }


}
