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
 * Class FiscalYear
 * @package Hasob\FoundationCore\Models
 * @version June 4, 2022, 12:01 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $organization_id
 * @property string $name
 * @property string $status
 * @property string $creator_user_id
 * @property string $start_date
 * @property string $end_date
 */
class FiscalYear extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_fiscal_years';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'organization_id',
        'name',
        'status',
        'creator_user_id',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'display_ordinal' => 'integer',
        'name' => 'string',
        'is_current' => 'boolean',
        'status' => 'string'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'creator_user_id');
    }

}
