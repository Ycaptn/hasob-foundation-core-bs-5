<?php

namespace Hasob\FoundationCore\Models;

use Hasob\FoundationCore\Traits\GuidId;
use Hasob\FoundationCore\Traits\Ledgerable;
use Hasob\FoundationCore\Traits\Artifactable;
use Hasob\FoundationCore\Traits\OrganizationalConstraint;

use Eloquent as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DisabledItem
 * @package Hasob\FoundationCore\Models
 * @version June 4, 2022, 12:01 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $id
 * @property string $organization_id
 * @property string $disable_id
 * @property string $disable_reason
 * @property string $disabling_user_id
 */
class DisabledItem extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_disabled_items';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'disable_id',
        'disable_reason',
        'is_disabled',
        'disable_type',
        'disabling_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'disable_id' => 'string',
        'disable_type' => 'string',
        'is_disabled' => 'boolean',
        'is_current' => 'boolean',
        'disable_reason' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'disabling_user_id');
    }

}
