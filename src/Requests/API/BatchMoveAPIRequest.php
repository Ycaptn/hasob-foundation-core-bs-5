<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Models\BatchItem;
use Hasob\FoundationCore\Requests\AppBaseFormRequest;


class BatchMoveAPIRequest extends AppBaseFormRequest
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
            'move_to_batch_id' => 'required',
            'batchable_id' => 'required|max:150',
            'batchable_type' => 'required|max:150',
            'batch_id' => 'required|exists:fc_batches,id',
        ];
    }

    public function messages(){

        return [
            'move_to_batch_id.required' => "The Move to item is required",
            'batch.required' => "The Field is required",
            'batch.required' => "The Batchable Item(s) is required",
        ];
    }


}
