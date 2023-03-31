<?php

namespace Hasob\FoundationCore\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Hasob\FoundationCore\Models\Department;

class CreateDepartmentRequest extends AppBaseFormRequest
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
            'parent_id' => 'required_if:is_unit,==,1',
            'long_name' => 'required'
        ];
    }

    public function messages() {
        return [
            'parent_id.required_if' => 'The Parent Department field is required when Is Organizational Unit is checked.',
        ];
    }

    public function attributes() {
        return [
            'is_unit' => 'Is Organizational Unit',
            'parent_id' => 'Parent Department',
            'long_name' => 'Long Name',
        ];
    }
}
