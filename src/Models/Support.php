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
 * Class Address
 * @package Hasob\FoundationCore\Models
 * @version February 25, 2022, 12:29 pm UTC
 *
 * @property string $id
 * @property string $organization_id
 * @property string $label
 * @property string $contact_person
 * @property string $street
 * @property string $town
 * @property string $state
 * @property string $country
 * @property string $telephone
 */
class Support extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_announcements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'organization_id',
        'location',
        'support_type',
        'issue_type',
        'severity',
        'description',
        'creator_user_id',
        'designated_user_id',
        'status',
        'resolved_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'organization_id' => "string",
        'location' => "string",
        'support_type' => "string",
        'issue_type' => "string",
        'severity' => " string",
        'description' => "string",
        'creator_user_id' => "string",
        'designated_user_id' => "string",
        'status' => "boolean",
        'resolved_at' => "datetime"
    ];


    

}
