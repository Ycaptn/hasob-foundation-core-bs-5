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
 * Class Budget
 * @package Hasob\FoundationCore\Models
 * @version June 4, 2022, 12:01 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\FiscalYear $fiscalYear
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $id
 * @property string $organization_id
 * @property string $name
 * @property string $code
 * @property string $group
 * @property string $type
 * @property string $fiscal_year_id
 * @property string $creator_user_id
 */
class Budget extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_budgets';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'name',
        'code',
        'group',
        'type',
        'fiscal_year_id',
        'creator_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'group' => 'string',
        'type' => 'string',
        'status' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function fiscalYear()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\FiscalYear::class, 'fiscal_year_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'creator_user_id');
    }

}
