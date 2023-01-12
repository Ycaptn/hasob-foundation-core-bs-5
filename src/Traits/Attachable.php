<?php
namespace Hasob\FoundationCore\Traits;

use File;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Hasob\FoundationCore\Models\User;
use Hasob\FoundationCore\Models\Attachment;
use Hasob\FoundationCore\Models\Attachable as EloquentAttachable;
use Hasob\FoundationCore\Models\Department;
use Hasob\FoundationCore\Models\Setting;
use Hasob\FoundationCore\Models\Organization;


trait Attachable
{

    private $counter = 1;

    public function get_attachment($name){
        $attachables = EloquentAttachable::where('attachable_id', $this->id)
                                            ->where('attachable_type', get_class($this))    
                                            ->orderBy('created_at','desc')
                                            ->get();

        $attachments = [];
        foreach ($attachables as $attachable){
            if ($attachable->attachment != null && $attachable->attachment->label == $name){
                return $attachable->attachment;
            }
        }
        return null;
    }

    public function get_attachments($file_types = null){
        $attachables_query = EloquentAttachable::where('attachable_id', $this->id)
                                            ->where('attachable_type', get_class($this))    
                                            ->orderBy('created_at','desc');

        $attachables = $attachables_query->get();

        $attachments = [];
        foreach ($attachables as $attachable){
            if ($file_types != null){
                
                $attachment = $attachable->attachment;
                if (str_contains(strtolower($file_types), strtolower($attachment->file_type))){
                    $attachments []= $attachable->attachment;
                }

            } else {
                $attachments []= $attachable->attachment;
            }
        }
        return $attachments;
    }

    public function get_attachables($file_types = null){
        $attachables_query = EloquentAttachable::where('attachable_id', $this->id)
                                            ->where('attachable_type', get_class($this))    
                                            ->orderBy('created_at','desc');

        $attachables = $attachables_query->get();

        $attachments = [];
        foreach ($attachables as $attachable){
            if ($file_types != null){
                
                $attachment = $attachable->attachment;
                if (str_contains(strtolower($file_types), strtolower($attachment->file_type))){
                    $attachments []= $attachable;
                }

            } else {
                $attachments []= $attachable;
            }
        }
        return $attachments;
    }

    public function create_attachment(User $user, $name, $comments, $file){

        $rndFileName = strval(time()+$this->counter) . '.' . $file->getClientOriginalExtension();

        $attachment_storage = Setting::where('key', 'attachment_storage')->first();
        $storageType = $attachment_storage->value;
        //storage type specified
        if (strtolower($storageType) == "cloud") {
            $cloud_storage_type = Setting::where('key', 'attachment_cloud_storage_type')->first();
            $storageType = $cloud_storage_type->value;
            $path = Storage::disk($storageType)->putFileAs('uploads', $file, $rndFileName);
        } else {
            $path = $file->move(public_path('uploads'), $rndFileName);
        }

        $attach = new Attachment();
        $attach->path = (strtolower($storageType) != "local") ? $path : "public/uploads/{$rndFileName}";
        $attach->label = $name;
        $attach->organization_id = $user->organization_id;
        $attach->uploader_user_id = $user->id;
        $attach->description = $comments;
        $attach->file_type = $file->getClientOriginalExtension();
        $attach->storage_driver = strtolower($storageType);
        $attach->save();

        $this->counter += 1;
        return $attach;
    }

    public function create_attachable(User $user, Attachment $attachment){

        $attachable = new EloquentAttachable();
        $attachable->user_id = $user->id;
        $attachable->attachment_id = $attachment->id;
        $attachable->attachable_id = $this->id;
        $attachable->attachable_type = get_class($this);
        $attachable->save();

        return $attachable;
    }

    public function delete_attachment($name){
        $attachables = EloquentAttachable::where('attachable_id',  $this->id)
                                            ->where('attachable_type', get_class($this))    
                                            ->orderBy('created_at','desc')
                                            ->get();

        $attachments = [];
        foreach ($attachables as $attachable){
            if ($attachable->attachment != null && $attachable->attachment->label == $name){
                $attachable->attachment->delete();
                $attachable->delete();
            }
        }
        return null;
    }

    public function attach(User $user, $name, $comments, $file, $storageType=null){

        $rndFileName = strval(time()+$this->counter) . '.' . $file->getClientOriginalExtension();
        $attachment_storage = Setting::where('key', 'attachment_storage')->first();
        $storageType = $attachment_storage->value;
        
        //storage type specified
        if ($storageType == "Cloud") {
            $cloud_storage_type = Setting::where('key', 'attachment_cloud_storage_type')->first();
            $storageType = $cloud_storage_type->value;
            $path = Storage::disk($storageType)->putFileAs('uploads', $file, $rndFileName);
        } else {
            $path = $file->move(public_path('uploads'), $rndFileName);
        }

        $attach = new Attachment();
        $attach->path = ($storageType != "Local") ? $path : "public/uploads/{$rndFileName}";
        $attach->label = $name;
        $attach->organization_id = $user->organization_id;
        $attach->uploader_user_id = $user->id;
        $attach->description = $comments;
        $attach->file_type = $file->getClientOriginalExtension();
        $attach->storage_driver = strtolower($storageType);
        $attach->save();

        $attachable = new EloquentAttachable();
        $attachable->user_id = $user->id;
        $attachable->attachment_id = $attach->id;
        $attachable->attachable_id = $this->id;
        $attachable->attachable_type = get_class($this);
        $attachable->save();

        $this->counter += 1;
        return $attachable;
    }
    
    public function save_file(User $user, $name, $comments, $file_path){

        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
        $attachment_storage = Setting::where('key', 'attachment_storage')->first();
        $storageType = $attachment_storage->value;
        $rndFileName = strval(time()+$this->counter) . '.' . $file_extension;
        //storage type specified
        if ($storageType == "Cloud") {
            $cloud_storage_type = Setting::where('key', 'attachment_cloud_storage_type')->first();
            $storageType = $cloud_storage_type->value;
            $path = Storage::disk($storageType)->putFileAs('uploads', $file_path, $rndFileName);
        } else {
            $path = File::move($file_path, public_path('uploads').'/'.$rndFileName);
        }
       
       

        $attach = new Attachment();
        $attach->path = ($storageType != "Local") ? $path : "public/uploads/{$rndFileName}";
        $attach->label = $name;
        $attach->organization_id = $user->organization_id;
        $attach->uploader_user_id = $user->id;
        $attach->description = $comments;
        $attach->file_type = $file_extension;
        $attach->storage_driver = strtolower($storageType);
        $attach->save();

        $attachable = new EloquentAttachable();
        $attachable->user_id = $user->id;
        $attachable->attachment_id = $attach->id;
        $attachable->attachable_id = $this->id;
        $attachable->attachable_type = get_class($this);
        $attachable->save();

        $this->counter += 1;
        return $attachable;
    }

}
