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
 * Class LedgerReconciliation
 * @package Hasob\FoundationCore\Models
 * @version June 4, 2022, 12:01 pm UTC
 *
 * @property \Hasob\FoundationCore\Models\Ledger $ledger
 * @property \Hasob\FoundationCore\Models\User $user
 * @property string $organization_id
 * @property string $name
 * @property string $status
 * @property number $closing_balance_amount
 * @property string $ledger_id
 * @property string $creator_user_id
 * @property string $start_date
 * @property string $end_date
 */
class LedgerReconciliation extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_ledger_reconsiliations';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'organization_id',
        'name',
        'status',
        'closing_balance_amount',
        'ledger_id',
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
        'status' => 'string',
        'closing_balance_amount' => 'decimal:2',
        'is_reconciled' => 'boolean'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function ledger()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\Ledger::class, 'ledger_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function user()
    {
        return $this->hasOne(\Hasob\FoundationCore\Models\User::class, 'creator_user_id');
    }

}
