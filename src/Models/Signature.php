<?php

namespace Hasob\FoundationCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

class Signature extends Model
{
    use SoftDeletes;
    use GuidId;
    use OrganizationalConstraint;

    public $table = 'fc_signatures';
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $fillable = [
        'staff_name',
        'staff_title',
        'on_behalf',
        'owner_user_id',
        'organization_id'
    ];

    protected $casts = [
        'id' => 'string',
        'staff_name' => 'string',
        'staff_title' => 'string',
        'on_behalf' => 'string',
        'owner_user_id' => 'string',
        'organization_id' => 'string'
    ];

    
    public function user(){
        return $this->belongsTo(User::class,'owner_user_id','id');
    }
      

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    
}
