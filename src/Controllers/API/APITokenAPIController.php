<?php

namespace Hasob\FoundationCore\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use Laravel\Sanctum\PersonalAccessToken;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Traits\ApiResponder;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Requests\API\CreateAPITokenAPIRequest;
use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;

/**
 * Class APITokenAPIController
 * @package Hasob\FoundationCore\Controllers\API
 */

class APITokenAPIController extends AppBaseController
{

    use ApiResponder;

    public function index(Request $request, Organization $organization) {
        // 
    }


    public function store(CreateAPITokenAPIRequest $request, Organization $organization) {

        $api_token_user = User::find($request->get('api-token-user'));

        if (empty($api_token_user)) {
            return $this->sendError('The API Token User record was not found!');
        }

        $api_token = $api_token_user->createToken('API Token');
 
        $response_data = [
            'token' => $api_token->plainTextToken,
            'user' => $api_token_user,
        ];

        // APITokenCreated::dispatch($api_token_user);
        return $this->sendResponse($response_data, 'API Token generated & saved successfully.');
    }


    public function show($id, Organization $organization) {
        //
    }

    
    public function update($id, UpdateAPITokenAPIRequest $request, Organization $organization) {
        //
    }

     
    public function destroy(Request $request, $id, Organization $organization) {        

        $api_token = PersonalAccessToken::find($id);

        if (empty($api_token)) {
            return $this->sendError('API Token was not found!');
        }

        $api_token->delete();

        // APITokenDeleted::dispatch($api_token_user);
        return $this->sendSuccess('API Token revoked and trashed successfully.');
    }
}
