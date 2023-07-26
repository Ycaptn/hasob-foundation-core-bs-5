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
 * Class PaymentDisbursement
 * @package Hasob\FoundationCore\Models
 * @version July 21, 2023, 3:33 pm UTC
 *
 * @property string $id
 * @property string $organization_id
 * @property number $amount
 * @property string $payable_type
 * @property string $payable_id
 * @property string $bank_account_number
 * @property string $bank_name
 * @property string $bank_sort_code
 * @property string $gateway_reference_code
 * @property string $status
 * @property string $gateway_initialization_response
 * @property string $payment_instrument_type
 * @property string $payment_instrument_type
 * @property boolean $is_verified
 * @property boolean $is_verification_passed
 * @property boolean $is_verification_failed
 * @property string|\Carbon\Carbon $transaction_date
 * @property number $verified_amount
 * @property string $verification_meta
 * @property string $verification_notes
 */
class PaymentDisbursement extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_payment_disbursements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'amount',
        'bank_account_number',
        'bank_name',
        'bank_sort_code',
        'gateway_reference_code',
        'status',
        'gateway_initialization_response',
        'payment_instrument_type',
        'payment_instrument_type',
        'is_verified',
        'is_verification_passed',
        'is_verification_failed',
        'gateway_payment_detail_id',
        'transaction_date',
        'verified_amount',
        'verification_meta',
        'verification_notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'bank_account_number' => 'string',
        'bank_name' => 'string',
        'bank_sort_code' => 'string',
        'gateway_name' => 'string',
        'gateway_reference_code' => 'string',
        'status' => 'string',
        'gateway_initialization_response' => 'string',
        'payment_instrument_type' => 'string',
        'is_verified' => 'boolean',
        'is_verification_passed' => 'boolean',
        'is_verification_failed' => 'boolean',
        'transaction_date' => 'datetime',
        'verified_amount' => 'decimal:2',
        'verification_meta' => 'string',
        'verification_notes' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string',
    ];

    /**
     * Get the gateway_payment_detail that owns the PaymentDisbursement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gateway_payment_detail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GateWayPaymentDetail::class, 'gateway_payment_id', 'id');
    }


    

}
