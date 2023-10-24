<?php

namespace Hasob\FoundationCore\Controllers;

use Hasob\FoundationCore\Models\Attachable;
use Hasob\FoundationCore\Models\Attachment;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends BaseController
{

    public function index(Organization $org, Request $request)
    {}

    public function destroy(Organization $org, Request $request, $id)
    {
        $attach = Attachment::find($id);
        if (empty($attach)) {
            $err_msg = ['Attachment not found'];
            return self::createJSONResponse("fail", "error", $err_msg, 404);
        }
        $path = str_replace('public/', '', $attach->path);
        File::delete($path);
        Attachable::where('attachment_id', $attach->id)->delete();
        $attach->delete();

        $msg = ['Attachment deleted successfully'];

        return self::createJSONResponse("ok", "success", $msg, 200);

    }
    public function edit(Organization $org, Request $request, $id)
    {
        return $this->show($org, $request, $id);
    }

    public function show(Organization $org, Request $request, $id)
    {

        $attach = Attachment::find($id);
        if ($attach != null) {

            $slugged_label = \Str::slug($attach->label);
            if ($attach->storage_driver == 'azure' || $attach->storage_driver == 's3') {

                $file_type = $attach->file_type;
                // check if webdav functionality is on and the file extensions are xlsx, doc,docx,ppt,pptx,xls
                if (in_array($attach->file_type, ["xlsx", "doc", "docx", "ppt", "pptx", "xls"]) && env('WEBDAV_ON') == true && $request->download == false) {

                    return $this->getFileFromWebDavServer($attach);
                }

                return Storage::disk($attach->storage_driver)->download(
                    $attach->path,
                    $slugged_label,
                    ['Content-Disposition' => 'inline; filename="' . $slugged_label . "." . $attach->file_type . '"']
                );
            }

            if ($attach->file_type == 'pdf') {
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $slugged_label . "." . $attach->file_type . '"',
                    ]
                );
            } else if ($attach->file_type == 'docx' || $attach->file_type == 'doc') {
                if (in_array($attach->file_type, ["xlsx", "doc", "docx", "ppt", "pptx", "xls"]) && env('WEBDAV_ON') == true && $request->download == false) {
                    return $this->getFileFromWebDavServer($attach);
                }
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-word',
                        'Content-Disposition' => 'attachment; filename="' . $slugged_label . "." . $attach->file_type . '"',
                    ]
                );
            } else if ($attach->file_type == 'pptx' || $attach->file_type == 'ppt') {
                if (in_array($attach->file_type, ["xlsx", "doc", "docx", "ppt", "pptx", "xls"]) && env('WEBDAV_ON') == true && $request->download == false) {
                    return $this->getFileFromWebDavServer($attach);
                }
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-powerpoint',
                        'Content-Disposition' => 'attachment; filename="' . $slugged_label . "." . $attach->file_type . '"',
                    ]
                );
            } else if ($attach->file_type == 'xlsx' || $attach->file_type == 'xls') {

                if (in_array($attach->file_type, ["xlsx", "doc", "docx", "ppt", "pptx", "xls"]) && env('WEBDAV_ON') == true && $request->download == false) {
                    return $this->getFileFromWebDavServer($attach);
                }
                ob_end_clean();
                return response()->file(
                    base_path($attach->path),
                    [
                        'Content-Type: application/vnd.ms-excel',
                        'Content-Disposition' => 'attachment; filename="' . $slugged_label . "." . $attach->file_type . '"',
                    ]
                );
            }

            return response()->file(base_path($attach->path));
        }
    }

    public function getFileFromWebDavServer($attach)
    {
        //Get the file fro the storage bucket and write it to disk
        //check ig file is already on webdav
        $url = env('WEBDAV_UPLOAD_ENDPOINT');
        $username = env('LDAP_UPLOAD_USER');
        $password = env('LDAP_UPLOAD_PASSWORD');
        $path_arr = explode('/', $attach->path);
        $file_name = array_pop($path_arr);
        $ch = curl_init();
        //dd($url.'/'.$attach->path);
        curl_setopt($ch, CURLOPT_URL, $url . '/' . $file_name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Depth: 0']);
        $result = curl_exec($ch);
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response_code >= 200 && $response_code < 300) {
            $msg = ['url' => env('WEBDAV_UPLOAD_ENDPOINT') . $file_name, 'file_type' => $attach->file_type];
            return self::createJSONResponse("ok", "success", $msg, 200);
        }
        if(strtolower($attach->storage_driver) == "local"){
            $target_file = public_path($attach->path); 
        }else{
            Storage::disk('local')->put($attach->path, Storage::disk($attach->storage_driver)->get($attach->path));
            $target_file = storage_path("app/" . $attach->path);
        }
      

        // Set cURL options to copy file to webdav server
        curl_setopt($ch, CURLOPT_URL, $url . '/' . $file_name);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_UPLOAD, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_INFILE, fopen($target_file, 'r'));
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($target_file));
        // Execute the cURL request
        $result = curl_exec($ch);
        // delete the file from local disk
        if(strtolower($attach->storage_driver) != "local"){
            unlink($target_file);
        }
          
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response_code >= 201 && $response_code < 300) {

            $msg = ['url' => env('WEBDAV_UPLOAD_ENDPOINT') . $file_name, 'file_type' => $attach->file_type];
            return self::createJSONResponse("ok", "success", $msg, 200);
        } else {
            $err_msg = ['Error copying file to webdav server'];
            return self::createJSONResponse("fail", "error", $err_msg, 404);
        }

    }

    public function update(Organization $org, Request $request)
    {

        $options = json_decode($request->options, true);
        if (isset($options['name']) == false || $options['name'] == null || empty($options['name'])) {
            $err_msg = ['The name must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['attachable_id']) == false || empty($options['attachable_id'])) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }
        if (isset($options['attachable_type']) == false || empty($options['attachable_type']) || class_exists($options['attachable_type']) == false) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $attachable_type = $options['attachable_type']::find($options['attachable_id']);
        if ($attachable_type == null) {
            $err_msg = ['Invalid upload request.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        if (($request->file == null || $request->file == 'undefined') && $request->blob == null) {
            $err_msg = ['The file must be provided.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        if ($request->file != null && $request->file != 'undefined') {
            $attachment = $attachable_type->create_attachment(
                Auth::guard()->user(),
                isset($options['name']) ? $options['name'] : 'Unnamed File {{ time() }}',
                isset($options['comments']) ? $options['comments'] : "",
                $request->file
            );
        } elseif ($request->blob != null) {
            $attachment = $attachable_type->create_attachment_blob(
                Auth::guard()->user(),
                isset($options['name']) ? $options['name'] : 'Unnamed File {{ time() }}',
                isset($options['comments']) ? $options['comments'] : "",
                $request->blob
            );
        }

        if ($attachment == null) {
            $err_msg = ['Unable to upload attachment.'];
            return self::createJSONResponse("fail", "error", $err_msg, 200);
        }

        $attachable = $attachable_type->create_attachable(
            Auth::guard()->user(),
            $attachment
        );

        return self::createJSONResponse("ok", "success", $attachment, 200);
    }

    public function displayAttachmentStats(Request $request)
    {

        $attachment_count = Attachment::count();
        $path_type_group_count = DB::table('fc_attachments')
            ->select('path_type', DB::raw('count(*) as total'))
            ->groupBy('path_type')
            ->get();

        $file_type_group_count = DB::table('fc_attachments')
            ->select('file_type', DB::raw('count(*) as total'))
            ->groupBy('file_type')
            ->get();

        $storage_driver_group_count = DB::table('fc_attachments')
            ->select('storage_driver', DB::raw('count(*) as total'))
            ->groupBy('storage_driver')
            ->get();

        return view('hasob-foundation-core::attachments.stats')
            ->with("attachment_count", $attachment_count)
            ->with("path_type_group_count", $path_type_group_count)
            ->with("file_type_group_count", $file_type_group_count)
            ->with("storage_driver_group_count", $storage_driver_group_count);

    }

}
