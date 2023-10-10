<?php

namespace Hasob\FoundationCore\Models;

use Hash;
use Response;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use Hasob\Workflow\Traits\Workable;
use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Pageable;
use Hasob\FoundationCore\Traits\Disable;
use Hasob\FoundationCore\Traits\Ratable;
use Hasob\FoundationCore\Traits\Taggable;
use Hasob\FoundationCore\Traits\Ledgerable;
use Hasob\FoundationCore\Traits\Attachable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reaction
 * @package Hasob\FoundationCore\Models
 * @version September 12, 2023, 6:34 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $id
 * @property string $organization_id
 * @property string $creator_user_id
 */
class Reaction extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    use SoftDeletes;
    use HasFactory;

    public $table = 'fc_reactions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'creator_user_id',
        'reactionable_type',
        'reactionable_id',
        'is_liked',
        'is_not_liked',
        'client_ip_address',
        'client_user_agent_string',
        'comments',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'string',
        'reactionable_id' => 'string',
        'reactionable_type' => 'string',
        'is_liked' => 'boolean',
        'is_not_liked' => 'boolean',
        'client_ip_address' => 'string',
        'client_user_agent_string' => 'string',
        'comments' => 'string'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'creator_user_id', 'id');
    }

}
