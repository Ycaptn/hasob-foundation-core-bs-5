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
 * Class GateWayPaymentDetail
 * @package Hasob\FoundationCore\Models
 * @version July 23, 2023, 10:24 pm UTC
 *
 * @property string $id
 * @property string $organization_id
 * @property string $payable_type
 * @property string $payable_id
 * @property string $type
 * @property string $bank_account_number
 * @property string $bank_name
 * @property string $bank_sort_code
 * @property string $account_gateway_code
 * @property string $status
 * @property string $currency
 */
class GateWayPaymentDetail extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_gateway_payment_details';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'organization_id',
        'payable_type',
        'payable_id',
        'type',
        'bank_account_number',
        'bank_name',
        'bank_sort_code',
        'account_gateway_code',
        'status',
        'currency'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'payable_type' => 'string',
        'type' => 'string',
        'bank_account_number' => 'string',
        'bank_name' => 'string',
        'bank_sort_code' => 'string',
        'gateway_name' => 'string',
        'account_gateway_code' => 'string',
        'status' => 'string',
        'currency' => 'string',
        'wf_status' => 'string',
        'wf_meta_data' => 'string'
    ];


    

}
