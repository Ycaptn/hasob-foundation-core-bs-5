<?php

namespace Hasob\FoundationCore\Controllers\API;

use Hasob\FoundationCore\Requests\API\CreateSignatureAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateSignatureAPIRequest;
use Hasob\FoundationCore\Models\Signature;

use Illuminate\Http\Request;

use Hasob\FoundationCore\Controllers\BaseController;
use Response;

use Hasob\FoundationCore\Models\Organization;

/**
 * Class SignatureController
 * @package Hasob\FoundationCore\Controllers\API
 */

class SignatureAPIController extends BaseController
{
    /**
     * Display a listing of the Signature.
     * GET|HEAD /signatures
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Signature::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        
        if ($organization != null){
            $query->where('organization_id', $organization->id);
        }

        $signatures = $query->get();

        return $this->sendResponse($signatures->toArray(), 'Signatures retrieved successfully');
    }

    /**
     * Store a newly created Signature in storage.
     * POST /signatures
     *
     * @param CreateSignatureAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSignatureAPIRequest $request, Organization $organization)
    {
        $input = $request->except('signature_image');
        $signature_file = null;

        /** @var Signature $signature */
        if ($request->signature_image != null && $request->signature_image !="undefined"){ 
            $temp = file_get_contents($request->signature_image);
            $signature_file = base64_encode($temp);
            array_merge($input, ["signature_image" => base64_encode($temp) ]) ;  
        }
        $signature = Signature::create($input);
        $signature->signature_image = $signature_file;
        $signature->save();
        
        return $this->sendResponse($signature->toArray(), 'Signature saved successfully');
    }

    /**
     * Display the specified Signature.
     * GET|HEAD /signatures/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Signature $signature */
        $signature = Signature::find($id);

        if (empty($signature)) {
            return $this->sendError('Signature not found');
        }

        return $this->sendResponse($signature->toArray(), 'Signature retrieved successfully');
    }

    /**
     * Update the specified Signature in storage.
     * PUT/PATCH /signatures/{id}
     *
     * @param int $id
     * @param UpdateSignatureAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSignatureAPIRequest $request, Organization $organization)
    {
        /** @var Signature $signature */
        $signature = Signature::find($id);

        if (empty($signature)) {
            return $this->sendError('Signature not found');
        }

        $input = $request->except('signature_image');
        $signature_file = null;
        if ($request->signature_image != null && $request->signature_image !="undefined"){ 
          //  dd($request->signature_image);
            $temp = file_get_contents($request->signature_image);
            $signature_file = base64_encode($temp);
            array_merge($input, ["signature_image" => base64_encode($temp) ]) ; 
        }
        $signature->fill($input);
        $signature->save();

        if($signature_file != null){
            $signature->signature_image = $signature_file;
            $signature->save();
        }
        return $this->sendResponse($signature->toArray(), 'Signature updated successfully');
    }

    /**
     * Remove the specified Signature from storage.
     * DELETE /signatures/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Signature $signature */
        $signature = Signature::find($id);

        if (empty($signature)) {
            return $this->sendError('Signature not found');
        }

        $signature->delete();
        return $this->sendSuccess('Signature deleted successfully');
    }
}
