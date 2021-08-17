<?php

namespace Hasob\FoundationCore\Controllers;

use Carbon;
use Session;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Comment;
use Hasob\FoundationCore\Models\Attachment;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Organization;

class AttachmentController extends BaseController
{

    public function index(Organization $org, Request $request){}
    public function delete(Organization $org, Request $request, $id){}
    public function edit(Organization $org, Request $request, $id){
        return $this->show($org, $request, $id);
    }

    public function show(Organization $org, Request $request, $id){

        $attach = Attachment::find($id);
        if ($attach != null) {

            if ($attach->storage_driver == 'azure') {
                return Storage::disk('azure')->download(
                    $attach->path,
                    $attach->label,
                    ['Content-Disposition' => 'inline; filename="' . $attach->label . '"']
                );
            }

            if ($attach->file_type == 'pdf') {
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $attach->label . '"'
                    ]
                );
            } else if ($attach->file_type == 'docx' || $attach->file_type == 'doc') {
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-word',
                        'Content-Disposition' => 'attachment; filename="' . $attach->label . "." . $attach->file_type . '"'
                    ]
                );
            } else if ($attach->file_type == 'pptx' || $attach->file_type == 'ppt') {
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-powerpoint',
                        'Content-Disposition' => 'attachment; filename="' . $attach->label . "." . $attach->file_type . '"'
                    ]
                );
            } else if ($attach->file_type == 'xlsx' || $attach->file_type == 'xls') {
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-excel',
                        'Content-Disposition' => 'attachment; filename="' . $attach->label . "." . $attach->file_type . '"'
                    ]
                );
            }

            return response()->file(base_path($attach->path));
        }        
    }

    public function update(Organization $org, Request $request){

        $options = json_decode($request->options, true);
        if ($options['name'] == null || empty($options['name'])) {
            $err_msg = ['The name must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (empty($options['attachable_id']) || empty($options['attachable_type'])) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (class_exists($options['attachable_type']) == false) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $attachable_type = $options['attachable_type']::find($options['attachable_id']);
        if ($attachable_type == null) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        if ($request->file == null) {
            $err_msg = ['The file must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $attachment = $attachable_type->create_attachment(
            Auth::guard()->user(),
            $options['name'],
            $options['comments'],
            $request->file
        );
        if ($attachment == null) {
            $err_msg = ['Unable to upload attachment.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $attachable = $attachable_type->create_attachable(
            Auth::guard()->user(),
            $attachment
        );

        return self::createJSONResponse("ok", "success", $attachment->path, 200);
    }

}
