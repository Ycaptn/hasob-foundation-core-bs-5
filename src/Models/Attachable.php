<?php

namespace Hasob\FoundationCore\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Commentable;
use Hasob\FoundationCore\Traits\Socialable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Artifactable;

class Attachable extends Model
{
    use SoftDeletes;
    use Artifactable;
    use Disable;
    use GuidId;
    use Taggable;

    public $table = 'fc_attachables';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'attachment_id',
        'user_id',
        'attachable_id',
        'attachable_type',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'attachment_id' => 'string',
        'attachable_type' => 'string',
        'attachable_id' => 'string'
    ];

    public function getCreateDateString(){
        
        return Carbon::parse($this->created_at)->format("M d, Y");
    }



    public function attachable(){
        return $this->morphTo();
    }
    
    public function attachment(){
        return $this->belongsTo(Attachment::class,'attachment_id','id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
}
