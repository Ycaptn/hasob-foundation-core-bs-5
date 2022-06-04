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
 * Class BudgetItem
 * @package Hasob\FoundationCore\Models
 * @version June 4, 2022, 12:01 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\Budget $budget
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $id
 * @property string $organization_id
 * @property string $title
 * @property string $code
 * @property string $group
 * @property string $type
 * @property string $location
 * @property string $description
 * @property number $allocated_amount
 * @property string $budget_id
 * @property string $creator_user_id
 */
class BudgetItem extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_budget_items';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'title',
        'code',
        'group',
        'type',
        'location',
        'description',
        'allocated_amount',
        'budget_id',
        'creator_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'code' => 'string',
        'group' => 'string',
        'type' => 'string',
        'location' => 'string',
        'description' => 'string',
        'allocated_amount' => 'decimal:2',
        'status' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function budget()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\Budget::class, 'budget_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'creator_user_id');
    }

}
