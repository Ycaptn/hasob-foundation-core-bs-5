<?php

namespace Hasob\FoundationCore\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\Commentable;
use Hasob\FoundationCore\Traits\Socialable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

class Attachment extends Model
{
    use SoftDeletes;
    use Artifactable;
    use Disable;
    use GuidId;
    use OrganizationalConstraint;

    public $table = 'fc_attachments';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'uploader_user_id',
        'path',
        'path_type',
        'label',
        'description',
        'file_type',   
        'file_number',
        'storage_driver',
        'allowed_viewer_user_ids',
        'allowed_viewer_user_roles',
        'allowed_viewer_user_departments',
        'organization_id' 
    ];

    protected $casts = [
        'id' => 'string',
        'uploader_user_id' => 'string',
        'path' => 'string',
        'path_type' => 'string',
        'label' => 'string',
        'description' => 'string',
        'file_type' => 'string',
        'file_number' => 'string',
        'storage_driver' => 'string',
        'allowed_viewer_user_ids' => 'string',
        'allowed_viewer_user_roles' => 'string',
        'allowed_viewer_user_departments' => 'string',
        'organization_id' => 'string'
    ];

    public function attachables(){
        return $this->morphMany(Attachable::class, 'attachables');
    }

    public function uploader(){
        return $this->hasOne(User::class,'id','uploader_user_id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function getCreatedDateString(){
        return Carbon::parse($this->created_at)->format("M d, Y");
    }    
    
    public function can_role_view($user){
        if ($this->allowed_viewer_user_roles != null){
          $allowed_roles = explode(",",$this->allowed_viewer_user_roles);
          if (!$user->hasAnyRole($allowed_roles)){
            return false;
          }
        }
        return true;
    }

    public function viewers_user_list(){

        $viewer_ids = explode(',',$this->allowed_viewer_user_ids);
        $viewer_users_objects = User::whereIn('id', $viewer_ids)->get();
        $viewer_users_full_names = $viewer_users_objects->map(function ($item, $key) {
            return $item->full_name;
        });
    
        return implode(", ", $viewer_users_full_names->all());
    }
}
