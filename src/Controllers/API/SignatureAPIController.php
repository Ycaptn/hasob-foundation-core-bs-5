<?php

namespace Hasob\FoundationCore\Controllers\API;

use Hasob\FoundationCore\Controllers\BaseController;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\Signature;
use Hasob\FoundationCore\Requests\API\CreateSignatureAPIRequest;
use Hasob\FoundationCore\Requests\API\UpdateSignatureAPIRequest;
use Illuminate\Http\Request;
use Response;

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

        if ($organization != null) {
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
        if ($request->signature_image != null && $request->signature_image != "undefined") {
            list($original_width, $original_height) = getimagesize($request->signature_image);
            $new_width = 150;
            $new_height = 80;
            $image_p = imagecreatetruecolor($new_width, $new_height);
            $image = imagecreatefromjpeg($request->signature_image);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $resize_file_name = public_path() . "/" . time() . "-resize.jpg";
            $save = imagejpeg($image_p, $resize_file_name, 100);
            if ($save) {
                $temp = file_get_contents($resize_file_name);
                $signature_file = base64_encode($temp);
                array_merge($input, ["signature_image" => $signature_file]);
                unlink($resize_file_name);
            }
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
        if ($request->signature_image != null && $request->signature_image != "undefined") {
            list($original_width, $original_height) = getimagesize($request->signature_image);
            $new_width = 150;
            $new_height = 80;
            $image_p = imagecreatetruecolor($new_width, $new_height);

            $image = imagecreatefromjpeg($request->signature_image);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
            $resize_file_name = public_path() . "/" . time() . "-resize.jpg";
            $save = imagejpeg($image_p, $resize_file_name, 100);          
            if ($save) {
                $temp = file_get_contents($resize_file_name);
                $signature_file = base64_encode($temp);
                array_merge($input, ["signature_image" => $signature_file]);
                unlink($resize_file_name);
            }
        }
        $signature->fill($input);
        $signature->save();

        if ($signature_file != null) {
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
