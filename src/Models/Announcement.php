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
class Announcement extends Model
{
    use GuidId;
    use OrganizationalConstraint;
    
    use SoftDeletes;

    use HasFactory;

    public $table = 'fc_announcements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'organization_id',
        'headline',
        'content',
        'display_ordinal',
        'is_sticky',
        'is_flashing',
        'start_date',
        'end_date',
        'audience_department_ids',
        'creator_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'organization_id' => "string",
        'headline'  => "string",
        'content'=> "string",
        'display_ordinal' => "integer",
        'is_sticky' => "boolean",
        'is_flashing' => "boolean",
        'start_date' => "datetime",
        'end_date' => "datetime",
        'audience_department_ids',
        'creator_user_id' => "string"
    ];


    public function creator_user()
    {
        return $this->belongsTo(User::class, 'creator_user_id', 'id');
    }

}
