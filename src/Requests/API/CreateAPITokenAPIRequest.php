<?php

namespace Hasob\FoundationCore\Requests\API;

use Hasob\FoundationCore\Requests\AppBaseFormRequest;

class CreateAPITokenAPIRequest extends AppBaseFormRequest
{
    
    public function authorize() {
        if (auth()->user()->hasRole('admin')) {
            return true;
        }
        return false;
    }

    public function rules() {
        return [
            'api-token-user' => 'required|uuid|exists:fc_users,id',
            'organization_id' => 'required|uuid|exists:fc_organizations,id'
        ];
    }

    public function attributes() {
        return [
            'api-token-user' => 'API Token User',
            'organization_id' => 'Organization ID',
        ];
    }

}
